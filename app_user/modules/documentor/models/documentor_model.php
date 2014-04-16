<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Documentor_model extends CI_Model {
	
	
	/**
	*	@desc Returns sub directory name of a directory. The main purpose of this function is to grab the modules name of the projects.
	*
	*   @name get_dirs
	*	@access public
	*	@param string[module dir path], enum[ignore documentor module = true]
	*	@return returns the list of modules
	*	
	*/
	
	function get_dirs($source_dir,$ignore_documentor = true)
	{
		$modules = glob($source_dir . '/*' , GLOB_ONLYDIR);
		if($modules){
			foreach($modules as $key => $val){
				if($ignore_documentor){
					if($val != 'application/modules/documentor'){
						$modules[$key] = str_replace('application/modules/','',$val);
					}else{
						unset($modules[$key]);	
					}
				}else{
					$modules[$key] = str_replace('application/modules/','',$val);
				}
				
			}
		}
		
		return $modules;

	}
	
	function insert_modules($data)
	{
		if($data){
			return $this->db->insert('project_modules',$data);	
		}
	}
	
	function get_all_modules(){
		$modules = $this->db->get('project_modules')->result();
		if($modules){
			return $modules;	
		}
		return false;
	}
	

	//get file names form directory
	function get_file_names_from_folder($source_dir)
	{
		if(is_dir($source_dir)){
			$file_names = get_filenames($source_dir);
			return array_unique($file_names);
		}
	}
	
	function get_code($file_location,$function_name)
	{
		if($file_location)
		{	
			$code = '';
			$found = false;
			$completed = false;
			$lines = file($file_location);
			foreach($lines as $line)
			{
				//if function block found
				if(!$completed)
				{
					if(!$found)
					{
						if (strpos($line,'function '.$function_name) !== false)
						{
							//add first line
							$code .= $line;
							$found = true;
						}
					}
					else
					{
						if ((strpos($line,'function') === false) && (strpos($line,'/**') === false))
						{
							//add lines until the function block ends
							$code .= $line;
						}
						else
						{
							$completed = true;	
						}
						
					}
				}
			}
			return $code;
		}
	}
	
	
	function get_documenation($file_location,$file_name)
	{
		$tokens = token_get_all(file_get_contents($file_location));
		$count = 0;
		$class_info = array();
		$documentation = array();
		$functions = array();
		$class_info['class_name'] = ucwords(str_replace('.php','',$file_name));
		foreach($tokens as $token) 
		{
			if($token[0] == T_DOC_COMMENT)
			{
				//get doc comments
				$line = $token[1];
				//create doc array
				$doc_array = explode('*',$line);
				//initiate custom attribute counter which has not been pre defined
				$func_counter = 0;
				//create document elements
				foreach($doc_array as $line)
				{
					if(trim($line) != '/' && trim($line) != '')
					{
						//main class description
						$head = trim(strtok($line,' '));
						$desc = str_replace($head,'',$line);
						$title = str_replace('@','',$head);
						switch($head)
						{
							case '@class_desc':
							case '@class_desc:':
								$class_info['class_desc'] = $desc;
							break;
							
							case '@class_comments':
							case '@class_comments:':
								$class_info['class_comments'] = $desc;
							break;
							
							case '@access':
							case '@access:':
								$functions[$count]['function_access'] = $desc;
							break;
							
							case '@name':
							case '@name:':
								$functions[$count]['function_name'] = $desc;
								$functions[$count]['function_code'] = $this->get_code($file_location,trim($desc));
							break;
							
							case '@desc':
							case '@desc:':
								$functions[$count]['function_desc'] = $desc;
							break;	
							
							case '@comments':
							case '@comments:':
								$functions[$count]['function_comments'] = $desc;
							break;
							
							case '@param':
							case '@param:':
								$functions[$count]['function_param'] = $desc;
							break;
							
							
							default:
								$functions[$count]['function_attr'][$func_counter]['attr_name'] = $title;
								$functions[$count]['function_attr'][$func_counter]['attr_desc'] = $desc;
								$func_counter++;
							break;
						}
					}
				}$count++;
			}
		}
		$documentation['class_info'] = $class_info;
		$documentation['functions'] = $functions;
		return $documentation;
	}
	
	function add_documents($project_modules_id,$mvc_type,$documents)
	{
		//echo '<pre>'.print_r($documents).'</pre>';exit();
		if($project_modules_id && $mvc_type && $documents){
    		$modules_mvc_data = array(
									'project_modules_id' => $project_modules_id,
									'mvc_type' => $mvc_type,
									'name' => $documents['class_info']['class_name'],
									'description' => (isset($documents['class_info']['class_desc']) ? trim($documents['class_info']['class_desc']) : 'Description has not been added to this class'),
									'comment' => (isset($documents['class_info']['class_comments']) ? trim($documents['class_info']['class_comments']) : '')
								 	);
    		$modules_mvc_id = $this->insert_modules_mvc($modules_mvc_data);
			if($modules_mvc_id){
				$this->add_functions($modules_mvc_id,$documents['functions']);
			}
		}
	}
	
	function insert_modules_mvc($data)
	{
		if($data){
			$this->db->insert('modules_mvc',$data);
			return $this->db->insert_id();	
		}
		return false;
	}
	
	function add_functions($modules_mvc_id,$functions)
	{
		if($modules_mvc_id && $functions){
						
			foreach($functions as $func){
				$function_data = array(
									'modules_mvc_id' => $modules_mvc_id,
									'name' => (isset($func['function_name']) ? trim($func['function_name']) : ''),
									'access' => (isset($func['function_access']) ? trim($func['function_access']) : ''),
									'description' => (isset($func['function_desc']) ? trim($func['function_desc']) : ''),
									'comment' => (isset($func['function_comments']) ? trim($func['function_comments']) : ''),
									'params' => (isset($func['function_param']) ? trim($func['function_param']) : ''),
									'attributes' => (isset($func['function_attr']) ? json_encode($func['function_attr']) : ''),
									'code' => (isset($func['function_code']) ? trim($func['function_code']) : '')
								);
				$this->insert_functions($function_data);
			}
		}
	}
	
	function insert_functions($data)
	{
		if($data){
			$this->db->insert('modules_functions',$data);	
			return $this->db->insert_id();	
		}
		return false;
	}
	
	function reset_tables()
	{
		$tables = array('modules_functions','modules_mvc','project_modules');
		//empty table
		foreach($tables as $tbl){
			$sql = "TRUNCATE TABLE ".$tbl;
			$this->db->query($sql);
		}
		//reset auto increments
		foreach($tables as $tbl){
			$sql = "ALTER TABLE ".$tbl." AUTO_INCREMENT=1";
			$this->db->query($sql);
		}
		
	}
	
	function get_total_mvc()
	{
		$sql = "select count(id) as total_records from modules_mvc";
		$result = $this->db->query($sql)->row();
		if($result){
			return $result->total_records;	
		}
		return false;
	}
	
	function get_modules_mvc($project_modules_id,$mvc_type)
	{
		if($project_modules_id && $mvc_type){
			$sql = "select * from modules_mvc where project_modules_id = ".$project_modules_id." and mvc_type = '".$mvc_type."' order by name asc";
			$mvc_component = $this->db->query($sql)->result();
			if($mvc_component){
				return $mvc_component;	
			}
		}
		return false;
	}
	
	function get_modules_mvc_by_id($id)
	{
		$module_mvc = $this->db->where('id',$id)->get('modules_mvc')->row();
		if($module_mvc){
			return $module_mvc;	
		}
		return false;
	}
	
	function get_functions($modules_mvc_id)
	{
		if($modules_mvc_id){
			$functions = $this->db->where('modules_mvc_id',$modules_mvc_id)->where('name != ','')->get('modules_functions')->result();
			if($functions){
				return $functions;	
			}
		}
		return false;
	}
	
	
	
	
}