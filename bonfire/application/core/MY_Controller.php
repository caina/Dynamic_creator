<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Bonfire
 *
 * An open source project to allow developers get a jumpstart their development of CodeIgniter applications
 *
 * @package   Bonfire
 * @author    Bonfire Dev Team
 * @copyright Copyright (c) 2011 - 2012, Bonfire Dev Team
 * @license   http://guides.cibonfire.com/license.html
 * @link      http://cibonfire.com
 * @since     Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Base Controller
 *
 * This controller provides a controller that your controllers can extend
 * from. This allows any tasks that need to be performed sitewide to be
 * done in one place.
 *
 * Since it extends from MX_Controller, any controller in the system
 * can be used in the HMVC style, using modules::run(). See the docs
 * at: https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc/wiki/Home
 * for more detail on the HMVC code used in Bonfire.
 *
 * @package    Bonfire\Core\Controllers
 * @category   Controllers
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/helpers/file_helpers.html
 *
 */
class Base_Controller extends MX_Controller
{


	/**
	 * Stores the previously viewed page's complete URL.
	 *
	 * @var string
	 */
	protected $previous_page;

	/**
	 * Stores the page requested. This will sometimes be
	 * different than the previous page if a redirect happened
	 * in the controller.
	 *
	 * @var string
	 */
	protected $requested_page;

	/**
	 * Stores the current user's details, if they've logged in.
	 *
	 * @var object
	 */
	protected $current_user = NULL;

	//--------------------------------------------------------------------

	/**
	 * Class constructor
	 *
	 */
	public function __construct()
	{
		Events::trigger('before_controller', get_class($this));

		parent::__construct();

		// Load Activity Model Since it's used everywhere.
		$this->load->model('activities/Activity_model', 'activity_model');

		// Auth setup
		$this->load->model('users/User_model', 'user_model');
		$this->load->library('users/auth');

		// Load our current logged in user so we can access it anywhere.
		if ($this->auth->is_logged_in())
		{
			$this->current_user = $this->user_model->find($this->auth->user_id());
			$this->current_user->id = (int)$this->current_user->id;
			$this->current_user->user_img = gravatar_link($this->current_user->email, 22, $this->current_user->email, "{$this->current_user->email} Profile");

			// if the user has a language setting then use it
			if (isset($this->current_user->language))
			{
				$this->config->set_item('language', $this->current_user->language);
			}

		}

		// Make the current user available in the views
		$this->load->vars( array('current_user' => $this->current_user) );

		// load the application lang file here so that the users language is known
		$this->lang->load('application');

		/*
			Performance optimizations for production environments.
		*/
		if (ENVIRONMENT == 'production')
		{
		    $this->db->save_queries = FALSE;

		    $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		}

		// Testing niceties...
		else if (ENVIRONMENT == 'testing')
		{
			$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		}

		// Development niceties...
		else if (ENVIRONMENT == 'development')
		{
			if ($this->settings_lib->item('site.show_front_profiler') AND has_permission('Bonfire.Profiler.View'))
			{
				// Profiler bar?
				if ( ! $this->input->is_cli_request() AND ! $this->input->is_ajax_request())
				{
					$this->load->library('Console');
					$this->output->enable_profiler(TRUE);
				}

			}

			$this->load->driver('cache', array('adapter' => 'dummy'));
		}

		// Auto-migrate our core and/or app to latest version.
		if ($this->config->item('migrate.auto_core') || $this->config->item('migrate.auto_app'))
		{
			$this->load->library('migrations/migrations');
			$this->migrations->auto_latest();
		}

		// Make sure no assets in up as a requested page or a 404 page.
		if ( ! preg_match('/\.(gif|jpg|jpeg|png|css|js|ico|shtml)$/i', $this->uri->uri_string()))
		{
			$this->previous_page = $this->session->userdata('previous_page');
			$this->requested_page = $this->session->userdata('requested_page');
		}

		// Pre-Controller Event
		Events::trigger('after_controller_constructor', get_class($this));
	}//end __construct()

	//--------------------------------------------------------------------

}//end Base_Controller


//--------------------------------------------------------------------

/**
 * Front Controller
 *
 * This class provides a common place to handle any tasks that need to
 * be done for all public-facing controllers.
 *
 * @package    Bonfire\Core\Controllers
 * @category   Controllers
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/helpers/file_helpers.html
 *
 */
class Front_Controller extends Base_Controller
{

	//--------------------------------------------------------------------

	/**
	 * Class constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();

		Events::trigger('before_front_controller');

		$this->load->library('template');
		$this->load->library('assets');

		Template::set_theme($this->config->item('default_theme'));

		Events::trigger('after_front_controller');
	}//end __construct()

	//--------------------------------------------------------------------

}//end Front_Controller


//--------------------------------------------------------------------

/**
 * Authenticated Controller
 *
 * Provides a base class for all controllers that must check user login
 * status.
 *
 * @package    Bonfire\Core\Controllers
 * @category   Controllers
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/helpers/file_helpers.html
 *
 */
class Authenticated_Controller extends Base_Controller
{

	//--------------------------------------------------------------------

	/**
	 * Class constructor setup login restriction and load various libraries
	 *
	 */
	public function __construct()
	{
		parent::__construct();

		// Make sure we're logged in.
		$this->auth->restrict();

		// Load additional libraries
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->CI =& $this;	// Hack to make it work properly with HMVC

		Template::set_theme($this->config->item('default_theme'));
	}//end construct()

	//--------------------------------------------------------------------


}//end Authenticated_Controller


//--------------------------------------------------------------------

/**
 * Admin Controller
 *
 * This class provides a base class for all admin-facing controllers.
 * It automatically loads the form, form_validation and pagination
 * helpers/libraries, sets defaults for pagination and sets our
 * Admin Theme.
 *
 * @package    Bonfire
 * @subpackage MY_Controller
 * @category   Controllers
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/helpers/file_helpers.html
 *
 */
class Admin_Controller extends Authenticated_Controller
{

	//--------------------------------------------------------------------

	/**
	 * Class constructor - setup paging and keyboard shortcuts as well as
	 * load various libraries
	 *
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('application');

		$this->load->library('template');
		$this->load->library('assets');
		$this->load->library('ui/contexts');

		// Pagination config
		$this->pager = array();
		$this->pager['full_tag_open']	= '<div class="pagination pagination-right"><ul>';
		$this->pager['full_tag_close']	= '</ul></div>';
		$this->pager['next_link'] 		= '&rarr;';
		$this->pager['prev_link'] 		= '&larr;';
		$this->pager['next_tag_open']	= '<li>';
		$this->pager['next_tag_close']	= '</li>';
		$this->pager['prev_tag_open']	= '<li>';
		$this->pager['prev_tag_close']	= '</li>';
		$this->pager['first_tag_open']	= '<li>';
		$this->pager['first_tag_close']	= '</li>';
		$this->pager['last_tag_open']	= '<li>';
		$this->pager['last_tag_close']	= '</li>';
		$this->pager['cur_tag_open']	= '<li class="active"><a href="#">';
		$this->pager['cur_tag_close']	= '</a></li>';
		$this->pager['num_tag_open']	= '<li>';
		$this->pager['num_tag_close']	= '</li>';

		$this->limit = $this->settings_lib->item('site.list_limit');

		// load the keyboard shortcut keys
		$shortcut_data = array(
			'shortcuts' => config_item('ui.current_shortcuts'),
			'shortcut_keys' => $this->settings_lib->find_all_by('module', 'core.ui'),
		);
		Template::set('shortcut_data', $shortcut_data);

		// Profiler Bar?
		if (ENVIRONMENT == 'development')
		{
			if ($this->settings_lib->item('site.show_profiler') AND has_permission('Bonfire.Profiler.View'))
			{
				// Profiler bar?
				if ( ! $this->input->is_cli_request() AND ! $this->input->is_ajax_request())
				{
					$this->load->library('Console');
					$this->output->enable_profiler(TRUE);
				}
			}
		}

		// Basic setup
		Template::set_theme($this->config->item('template.admin_theme'), 'junk');
	}//end construct()

	//--------------------------------------------------------------------

}//end Admin_Controller

/* End of file MY_Controller.php */


/**
 * Dynamic Controller
 *
 *
 * @package    Bonfire
 * @subpackage MY_Controller
 * @category   Controllers
 * @author     mbr sistemas Team
 * @link       http://guides.cibonfire.com/helpers/file_helpers.html
 *
 */
class Dynamic_Controller extends Admin_Controller
{

	//--------------------------------------------------------------------
	var $model;

	public function __construct($json_config=false)
	{	
		parent::__construct();
		if($json_config){
			$json_config = json_decode($json_config);
			$this->load->library("dynamic_creator", $json_config);
			
			$this->model = $this->load->model($json_config->module, null, true);
		}

		
	}//end construct()


	public function index()
	{
		
		// Deleting anything?
		if (isset($_POST['delete']))
		{	
			$checked = $this->input->post('checked');
			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('guide_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('guide_delete_failure') . $this->model->error, 'error');
				}
			}
		}

		$records = $this->model->find_all();
		Template::set('table',  $this->dynamic_creator->generate_list_table($records));
		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Guide');
		Template::render();
	}



	/*
		Method: create()

		Creates a Guide object.
	*/
	public function create()
	{

		$this->auth->restrict($this->dynamic_creator->get_restriction().'.Create');

		if ($this->input->post('save'))
		{
			if ($insert_id = $this->save())
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('guide_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'guide');

				Template::set_message(lang('guide_create_success'), 'success');
				Template::redirect(SITE_AREA .$this->dynamic_creator->get_path());
			}
			else
			{
				Template::set_message(lang('guide_create_failure') . $this->guide_model->error, 'error');
			}
		}

		Template::set('form',  $this->dynamic_creator->create_form());
		Template::set('toolbar_title', lang('guide_create') . ' Guide');
		Template::render();
	}



	/*
		Method: edit()

		Allows editing of Guide data.
	*/
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('guide_invalid_id'), 'error');
			redirect(SITE_AREA . $this->dynamic_creator->get_path());
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict($this->dynamic_creator->get_restriction().'.Edit');

			if ($this->save('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('guide_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'guide');

				Template::set_message(lang('guide_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('guide_edit_failure') . $this->model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict($this->dynamic_creator->get_restriction().'.Delete');

			if ($this->model->delete($id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('guide_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'guide');

				Template::set_message(lang('guide_delete_success'), 'success');

				redirect(SITE_AREA . $this->dynamic_creator->get_path());
			} else
			{
				Template::set_message(lang('guide_delete_failure') . $this->model->error, 'error');
			}
		}
		Template::set('form',  $this->dynamic_creator->create_form($this->model->find($id)));

		Template::set('toolbar_title', lang('guide_edit') . ' Guide');
		Template::render();
	}




	/*
		Method: save_guide()

		Does the actual validation and saving of form data.

		Parameters:
			$type	- Either "insert" or "update"
			$id		- The ID of the record to update. Not needed for inserts.

		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

		// if ($this->form_validation->run() === FALSE)
		// {
		// 	return FALSE;
		// }

		// make sure we only pass in the fields we want

		$data = array();
		$data = $this->dynamic_creator->convert_post_data($this->input->post());
		if ($type == 'insert')
		{
			$id = $this->model->insert($data);

			if (is_numeric($id))
			{
				$return = $id;
			} else
			{
				$return = FALSE;
			}
		}
		else if ($type == 'update')
		{
			$return = $this->model->update($id, $data);
		}

		return $return;
	}


	//--------------------------------------------------------------------

}//end Admin_Controller




/* Location: ./application/core/MY_Controller.php */
