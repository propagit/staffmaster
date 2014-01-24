<?php

class Documentor extends CI_Controller {

   public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
	}
	
	function document_this()
	{
		$source_dir = 'application/controllers';
		$files = $this->_get_file_names_from_folder($source_dir);	
		foreach($files as $file)
		{
			trim($file);
			if($file != 'documentor.php' && $file != 'index.html')
			{
				$data['documents']['class_info']['component_type'] = 'controllers';
				$data['documents'] = $this->_get_documenation($source_dir.'/'.$file,$file);
			}
			
		}
	}
	
	//get file names form directory
	function _get_file_names_from_folder($source_dir)
	{
		if($source_dir)
		{
			$file_names = get_filenames($source_dir);
			return array_unique($file_names);
		}
	}
	
	function _get_code($file_location,$function_name)
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
	
	
	function _get_documenation($file_location,$file_name)
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
								$class_info['name'] = $desc;
							break;
							
							case '@class_comments':
								$class_info['comments'] = $desc;
							break;
							
							case '@access':
								$functions[$count]['function_access'] = $desc;
							break;
							
							case '@name':
								$functions[$count]['function_name'] = $desc;
								$functions[$count]['function_code'] = $this->_get_code($file_location,trim($desc));
							break;
							
							case '@desc':
								$functions[$count]['function_desc'] = $desc;
							break;	
							
							case '@comments':
								$functions[$count]['function_comments'] = $desc;
							break;
							
							case '@param':
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
	
	function _add_component($data)
	{
		if($data){
			return $this->db->insert('components',$data)->insert_id();	
		}
		return false;
	}
	
	function _add_functions($component_id,$data)
	{
		if($component_id && $data){
			return $this->db->insert('functions',$data)->insert_id();		
		}
		return false;
	}

	
	
	
	
  
}
?>