<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class roteiros extends Dynamic_Controller {

	//--------------------------------------------------------------------



	public function __construct()
	{
		$configurations = <<<EOT
		{
		  "permission": "Guide.Roteiros",
		  "path":"roteiros/guide",
		  "primary_key" : "id",
		  "table": "bf_guide",
		  "module": "guide/guide_model",
		  "labels": {
		    "description": "Descricao",
		    "user_id": "Usuário"
		  },
		  "remove_list": [
		    "id"
		  ],

		  "options": {
		    "foreign_keys": {
		      "user_id": {
		        "table": "users",
		        "field": "username",
		        "filter": "id"
		      }
		    },
		    "images": {
		      "foto_capa": {
		      	"size":"500x600",
		      	"image_path":""
		      }
		    }
		  }
		}
EOT;
		// $configurations = json_encode($configurations);

		parent::__construct($configurations);

		$this->auth->restrict('Guide.Roteiros.View');
		$this->load->model('guide_model', null, true);
		$this->lang->load('guide');
		

		Template::set_block('sub_nav', 'roteiros/_sub_nav');
	}




}