<?php
/****
	CRIA FORMS USANDO OS DADOS DA TABELA NO BANCO
	E COMBINA COM OS DADOS DE CONFIGURAÇÃO DO MÓDULO
*/
class Dynamic_creator {
	
	var $ci;
	var $db;
	var $html;
	var $form;
	var $config;
	var $form_data;
	var $table_structure = false;


	public function __construct($configuration){
		$this->config = $configuration;
		$this->ci =&get_instance();
		$this->db = $this->ci->db;
		$this->validate_config();

		$this->ci->load->helper("html");
		$this->ci->load->helper("form_helper");
	}

	/***
		GENERATE LIST TABLE FOR INDEX
		ON BONFIRE STYLE
	*/
	public function generate_list_table($data=false){
		$table = $this->ci->load->library('table');

		$table->set_template($this->get_table_template());
		$table->set_heading($this->get_table_headers());
		
		if($data !== FALSE){
			//lines
			foreach ($data as $list_data) {
				$row = array();
				
				$primary_key = $this->get_primary_key();
				$row[] = form_checkbox("checked[]", $list_data->$primary_key, FALSE).anchor(SITE_AREA . $this->get_path() .'/edit/'. $list_data->$primary_key, '<i class="icon-pencil">&nbsp;</i>' .  $list_data->$primary_key);
				//fields
				foreach ($list_data as $key => $value) {
					//edit


					if(!$this->is_field_on_blacklist($key))
						$row[] = $this->list_field_value($key, $value);
				}
				$table->add_row($row);
			}
		}

		$html  = form_open($this->ci->uri->uri_string());
		$html .= $table->generate();
		$html .= form_close();
		
		return $html;
	}

	/*****
		CREATE THE FORM
		EDIT AND CREATE
	*/
	public function create_form($fields_data= false){
		$this->table_structure = $this->get_table_structure();

		Assets::add_js("jasny-bootstrap.min.js");
		Assets::add_js("modernizr-2.5.3.js");
		Assets::add_css("jasny-bootstrap.min.css");

		$hiddens = array();
		//hiddens only on update
		if($fields_data !== FALSE){
			$primary_key = $this->get_primary_key();
			$hiddens = array($primary_key => $fields_data->$primary_key);
		}

		$form = "";
		$form .= form_open_multipart($this->ci->uri->uri_string(), 'class="form-horizontal"', $hiddens);
		
		foreach ($this->table_structure as $field_info) {
			$form .= $this->generate_input($field_info, $fields_data);
		}		

		$cancel_link = anchor(SITE_AREA .$this->get_path(), "Cancelar", "class='btn btn-warning'");
		$form .= "
		    <fieldset>
		        <div class='form-actions'>
		            <br/>
		            <input type='submit' name='save' class='btn btn-primary' value='Salvar' />
		            or {$cancel_link}
		            
		        </div>
		    </fieldset>
		";
		$form .= form_close();
		return $form;
	}



	private function get_form_hiddens(){
		$this->table_structure = $this->get_table_structure();
		$hiddens = array();
		foreach ($this->table_structure as $field_info) {
			if((isset($this->config->primary_key) && @$this->config->primary_key == $field_info->name) || $field_info->primary_key == 1){
				// $hiddens[$field_info->name] = 
			}
		}
	}

	private function generate_input($field_info, $value = false){
		$this->ci->load->helper("form_helper");	
		$html="";
		//pk?
		if((isset($this->config->primary_key) && @$this->config->primary_key == $field_info->name) || $field_info->primary_key == 1){
			return false;
		}else{

			$name = $field_info->name;

			if($value !== FALSE){
				if(is_object($value)){
					$value = $value->$name;
				}
			}

			$data = array(
              'name'        => $name,
              'id'          => $name,
              'value'       => ($value!==null) ? $value : '',
              'maxlength'   => $field_info->max_length,
              'size'        => '150',
              "label"		=> $this->get_table_label($field_info->name)
            );

			

			if($this->is_field_foreign_key($name)){
				$db_data = $this->foreign_key_search($this->config->options->foreign_keys->$name,false);
				$options = array();

				$field = $this->config->options->foreign_keys->$name->field;
				$filter = $this->config->options->foreign_keys->$name->filter;
				
				$options[0] = "Selecione";
				foreach ($db_data as $data) {
					$options[$data->$filter] = $data->$field;
				}

				$html = form_dropdown($name, $options, $value,$this->get_table_label($field_info->name));
			}else{
				$html = form_input($data);
			}

			return $html;
		}

		dump($field_info);die;
	}

	/***
	*/
	private function get_table_headers(){
		$this->table_structure = $this->get_table_structure();
		$header;

		$header[] = "<input class='check-all' type='checkbox' /> Op&ccedil;&otilde;es ";
			
		foreach ($this->table_structure as $table) {
			if(!$this->is_field_on_blacklist($table->name)){
				$header[] = $this->get_table_label($table->name);
			}
		}
		return $header;
	}

	/***

	*/
	private function list_field_value($key, $value){
		if(isset($this->config->options)){

			// dump($this->config->options);die;
			//images

			//foreign keys
			if($this->is_field_foreign_key($key)){
				$this->config->options->foreign_keys->$key->value = $value;
				return $this->foreign_key_search($this->config->options->foreign_keys->$key, 1);
			}
			//masks

		}
		return $value;
	}

	private function is_field_foreign_key($field){
		if(isset($this->config->options->foreign_keys)){
			return isset($this->config->options->foreign_keys->$field);
		}
		return false;
	}

	/****
		JSON NEEDED
	 "foreign_keys": {
	      "user_id": {
	        "table": "users",
	        "field": "username",
	        "filter": "id"
	      }
	    },
	*/
	private function foreign_key_search($object,$limit=1){
		
		if(isset($object->value)){
			$filter = "id";
			if(isset($object->filter)){
				$filter = $object->filter;
			}
			$this->db->where($filter,$object->value);
		}

		$this->db->from($object->table);
		if($limit === FALSE){
			return $this->db->get()->result();	
		}

		$this->db->limit($limit);
		$result = $this->db->get()->row();

		$field = $object->field;
		if(isset($result->$field)){
			return $result->$field;
		}
		return $object->value;
	}

	/****
	*/
	private function is_field_on_blacklist($index){
		if(isset($this->config->remove_list)){
			return in_array($index,$this->config->remove_list);
		}
		return false;
	}
	/***
		FIND VARIABLES ON LABEL CONFIG OBJECT,
		IF IS SET, USE HIS LABEL
	*/
	private function get_table_label($index){
		if(isset($this->config->labels)){
			if(isset($this->config->labels->$index)){
				return $this->config->labels->$index;
			}
		}
		return $index;
		// if(isset($this->config->))
	}
	/****
		CARREGA OS DADOS DA ESTRUTURA DA TABELA, APENAS ACESSIVEL DE DENTRO
	*/
	private function get_table_structure(){
		if($this->table_structure === FALSE){
			$this->table_structure = $this->db->field_data($this->config->table);
		}
		return $this->table_structure;
	}

	private function validate_config(){
		if(!isset($this->config->table)){
			dump($this->config);
			die("ERRO! TABLE NO CONFIG NAO FOI SETADA");
		}
		if(!isset($this->config->module)){
			dump($this->config);
			die("ERRO! MODULE NO CONFIG NAO FOI SETADA");
		}
	}

	private function get_table_template(){
		return array (
                    'table_open'          => '<table  class="table table-striped" >',

                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',

                    'row_start'           => '<tr>',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr>',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '
                    	<tfoot>
							<tr>
								<td colspan="99999">
									<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="Deletar" onclick="return confirm(\' Realmente deseja deletar \')">
								</td>
							</tr>
						</tfoot>
                    </table>'
              );
	}

	public function get_restriction(){
		if(isset($this->config->permission)){
			return $this->config->permission;
		}else{
			die("ADICIONE AS PERMISSOES");
		}
	}

	public function get_path(){
		if(isset($this->config->path)){
			return "/".$this->config->path;
		}
		return "";
	}

	private function get_primary_key(){
		$primary_key = "id";
		if(isset($this->config->primary_key)){
			$primary_key = $this->config->primary_key;
		}
		return $primary_key;
	}

	/****
	GET POST DATA THAT MATCH WITH THE DATABASE
	*/
	public function convert_post_data($post_data){
		$this->table_structure = $this->get_table_structure();
		$data=array();

		foreach ($post_data as $key => $value) {
			foreach ($this->table_structure as $structure) {
				if($key == $structure->name){
					$data[$key] = $value;
				}
			}
		}
		return $data;
	}
}
?>