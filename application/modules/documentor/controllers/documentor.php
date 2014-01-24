<?php

class Documentor extends MX_Controller {
	
	/**
	*	@class_desc Documentor controller. This controller generates documentation for the entire project. 
	*	@class_comments Dependent on Code Igniter file library
	*	
	*
	*/
	
   public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->model('documentor_model');
	}
	
	function index($method='', $param1='', $param2='', $param3='',$param4='')
	{
		switch($method)
		{
			case 'show_documentation':
				$this->show_documentation($param1);
			break;
			
			case 'get_documentation_nav':
				$this->get_documentation_nav($param1);
			break;
			
			case 'document_this':
				$this->document_this();
			break;
			
			default:
				$this->show_documentation();
			break;
			
		}
	}
	
	function get_documentation_nav()
	{
		$this->load->view('menu');	
	}
	
	
	function show_documentation($modules_mvc_id = 1)
	{
		$data['mvc'] = $this->documentor_model->get_modules_mvc_by_id($modules_mvc_id);
		$this->load->view('home',$data);
	}
	
	/**
	*	@desc This is the main function which initiate the documentation generation
	*
	*   @name document_this
	*	@access public
	*	@param null
	*	@return generates documentation
	*	
	*/
	

	
	function document_this()
	{
		$this->documentor_model->reset_tables();
		$modules_dir = 'application/modules';
		$modules = $this->documentor_model->get_dirs($modules_dir);
		//add modules to table project_modules
		foreach($modules as $m){
			$this->documentor_model->insert_modules(array('name' => $m));
		}  
		
		//get all modules form database
		$just_added_modules = $this->documentor_model->get_all_modules();
		
		//now for each modules scan for controllers and models and add to the database
		$mvc_names = array('controllers','models');
		foreach($just_added_modules as $jm){
			
			foreach($mvc_names as $mc_name){
				$mvc_dir = 'application/modules/'.$jm->name.'/'.$mc_name;
				$mvcs = $this->documentor_model->get_file_names_from_folder($mvc_dir);
				//generate documentation for each controller
				if($mvcs){
					foreach($mvcs as $mc){
						 trim($mc);
						//ignore index.html
						if($mc != 'index.html'){
							$documents = $this->documentor_model->get_documenation($mvc_dir.'/'.$mc,$mc);
							$this->documentor_model->add_documents($jm->id,$mc_name,$documents);
						}
						 
					} 
				}
			}
			
			
		}
		

	}
	
	
	
	
	
	
  
}
?>