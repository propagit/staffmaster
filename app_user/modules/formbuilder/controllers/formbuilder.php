<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@class_desc This module is used for building custom form. On staffmaster this will be used for adding custom attributes for staff. These attributes will then be searchable for any given staff. 
*	@class_comments 
*	
*
*/

class Formbuilder extends MX_Controller {



	function __construct()
	{
		parent::__construct();
		$this->load->model('formbuilder_model');
		//error_reporting(E_ALL);
	}
	
	function index($method='', $param1='', $param2='', $param3='',$param4='')
	{
		switch($method)
		{		
			case 'add_form':
				$this->add_form();
			break;
			
			default:
				$this->home();
			break;
			
		}
	}
	
	/**
	*	@desc This is the landing page of the formbuiler module. This page provides the necessary UI to build custom forms for the user.
	*
	*   @name home
	*	@access public
	*	@param null
	*	@return loads the view file home. which contains the UI elements to generate custom form elements.
	*	@comments Build by taking reference from http://minikomi.github.io/Bootstrap-Form-Builder. However it should be noted that the similarity is only limited to the UI and the actual functions are custom build.
	*	@author kaushtuv
	*/
	function home()
	{
		$this->load->view('home');	
	}
	
	/**
	*	@desc Shows the existing form for custom attributes.
	*
	*   @name existing_form_elements
	*	@access public
	*	@param null
	*	@return Loads existing form elements for custom attributes.
	*/
	function existing_form_elements()
	{
		$data['existing_elements'] = $this->formbuilder_model->get_form_elements();
		$this->load->view('existing_form',isset($data) ? $data : NULL);	
	}
	
	/**
	*	@desc Add Form
	*
	*   @name home
	*	@access public
	*	@param null
	*	@return null
	*/
	
	function add_form()
	{
		//echo '<pre>'.print_r($_POST,true).'</pre>';exit(0);

		//reset table
		$this->formbuilder_model->reset_tables();

		$textinput = $_POST['final_textinput'];
		$textarea = $_POST['final_textarea'];
		$multi_radio = $_POST['final_multi_radio'];
		$inline_radio = $_POST['final_inline_radio'];
		$multi_checkbox = $_POST['final_multi_checkbox'];
		$inline_checkbox = $_POST['final_inline_checkbox'];
		$basic_select = $_POST['final_basic_select'];
		$multi_select = $_POST['final_multi_select'];
		$filebutton = $_POST['final_filebutton'];
		
		$sort_order = $_POST['sort_order'];
		$decoded_sort_order = $this->_manual_jason_decode_sort_order($sort_order);		

		$decoded_textinput = $this->_manual_jason_decode($textinput);
		$this->_insert_data($decoded_textinput,'textinput',$decoded_sort_order);
		
		$decoded_textarea = $this->_manual_jason_decode($textarea);
		$this->_insert_data($decoded_textarea,'textarea',$decoded_sort_order);
		
		$decoded_multi_radio = $this->_manual_jason_decode($multi_radio,true);
		$this->_insert_data($decoded_multi_radio,'radio',$decoded_sort_order);
		
		$decoded_inline_radio = $this->_manual_jason_decode($inline_radio,true);
		$this->_insert_data($decoded_inline_radio,'radio',$decoded_sort_order,'yes');
		
		$decoded_multi_checkbox = $this->_manual_jason_decode($multi_checkbox,true);
		$this->_insert_data($decoded_multi_checkbox,'checkbox',$decoded_sort_order);
		
		$decoded_inline_checkbox = $this->_manual_jason_decode($inline_checkbox,true);
		$this->_insert_data($decoded_inline_checkbox,'checkbox',$decoded_sort_order,'yes');
		
		$decoded_basic_select = $this->_manual_jason_decode($basic_select,true);
		$this->_insert_data($decoded_basic_select,'select',$decoded_sort_order);
		
		$decoded_multi_select = $this->_manual_jason_decode($multi_select,true);
		$this->_insert_data($decoded_multi_select,'select',$decoded_sort_order,'yes');
		
		$decoded_filebutton = $this->_manual_jason_decode($filebutton);
		$this->_insert_data($decoded_filebutton,'filebutton',$decoded_sort_order); 

		redirect('formbuilder');
	}
	
	/**
	*	@desc This function is used to parse the data posted form formbuilder interface and prepare the data for insertion. Once the data has been prepared it is then inserted into the database.
	*
	*   @name _insert_data
	*	@access private
	*	@param object(form_elements),string(type of element),string(state if the form element is inline, default = no)
	*	@return does not return anything, simply adds the data to the database
	*/
	function _insert_data($decoded_obj,$type,$decoded_sort_order,$inline_multi = 'no')
	{
		$decoded_array = (array)$decoded_obj;
		//echo '<pre>'.print_r($decoded_array,true).'</pre>';exit(0);
		
		if($decoded_array && $type){
			switch($type){
				case 'textinput':
					foreach($decoded_array as $arr){
						$data = array(
							'type' => $type,
							'label' => $arr->label,
							'name' => $arr->name,
							'placeholder' => $arr->placeholder,
							'order' => $this->_get_element_order($decoded_sort_order,$arr->name)
							);	
						$this->formbuilder_model->insert_form($data);
					}
				break;	
				
				case 'textarea':
					foreach($decoded_array as $arr){
						$data = array(
							'type' => $type,
							'label' => $arr->label,
							'name' => $arr->name,
							'order' => $this->_get_element_order($decoded_sort_order,$arr->name)
							);	
						$this->formbuilder_model->insert_form($data);
					}
				break;
				
				case 'radio':
					foreach($decoded_array as $arr){
						$data = array(
							'type' => $type,
							'label' => $arr['attr']->label,
							'name' => $arr['attr']->name,
							'inline_element' => $inline_multi,
							'attributes' => json_encode($arr['values']),
							'order' => $this->_get_element_order($decoded_sort_order,$arr['attr']->name)
							);	
						$this->formbuilder_model->insert_form($data);
					}
				break;
				
				case 'checkbox':
					foreach($decoded_array as $arr){
						$data = array(
							'type' => $type,
							'label' => $arr['attr']->label,
							'name' => $arr['attr']->name,
							'multi_select' => 'yes',
							'inline_element' => $inline_multi,
							'attributes' => json_encode($arr['values']),
							'order' => $this->_get_element_order($decoded_sort_order,$arr['attr']->name)
							);	
						$this->formbuilder_model->insert_form($data);
					}
				break;
				
				case 'select':
					foreach($decoded_array as $arr){
						$data = array(
							'type' => $type,
							'label' => $arr['attr']->label,
							'name' => $arr['attr']->name,
							'multi_select' => $inline_multi,
							'attributes' => json_encode($arr['values']),
							'order' => $this->_get_element_order($decoded_sort_order,$arr['attr']->name)
							);	
						$this->formbuilder_model->insert_form($data);
					}
				break;
				
				case 'filebutton':
					foreach($decoded_array as $arr){
						$data = array(
							'type' => $type,
							'label' => $arr->label,
							'name' => $arr->name,
							'order' => $this->_get_element_order($decoded_sort_order,$arr->name)
							);	
						$this->formbuilder_model->insert_form($data);
					}
				break;
			}
		}
	}
	
	/**
	*	@desc This returns the order of the element
	*
	*   @name _get_element_order
	*	@access private
	*	@param array(array of elements and their order),string(element name)
	*	@return returns json decoded array that contains objects in inner levels
	*/
	function _get_element_order($order_array,$element_name)
	{
		if($order_array && $element_name){
			foreach($order_array as $key => $val){
					if($key == $element_name){
						return $val;	
					}
			}
		}
		return 0;	
	}
	
	/**
	*	@desc This function is used to manually decode the json data. This was done as the php build in json_decode failed to decode the multi level json string. 
	*
	*   @name _manual_jason_decode
	*	@access private
	*	@param json(form elements),enum(status if the data has multi dimension)
	*	@return returns json decoded array that contains objects in inner levels
	*/
	function _manual_jason_decode($data,$multi = false)
	{
		$temp_arr = array();
		$final_arr = array();
		$count = 0;
		$separator = $multi ? '],' : '},';
		$post_fix = $multi ? ']' : '}';
		if($data){
			if(!$multi){
				$temp_arr = explode($separator,$data);
				if(count($temp_arr) > 1){	
					$temp_arr[0] = $temp_arr[0].$post_fix;
				}
				foreach($temp_arr as $arr){
					$final_arr[$count] = json_decode($arr);	
					$count++;	
				}
			}else{
				$temp_arr = explode($separator,$data);
				if(count($temp_arr) > 1){		
					$temp_arr[0] = $temp_arr[0].$post_fix;	
				}
				$multi_arr = array();
				foreach($temp_arr as $arr){
					$multi_arr = json_decode($arr);
					$inner_counter = 0;
					$temp_multi_arr = array();
					if($multi_arr){
						foreach($multi_arr as $ma){
							if($inner_counter == 0){
								$temp_multi_arr['attr'] = json_decode($ma); 	
							}else{
								$temp_multi_arr['values'][$inner_counter] = json_decode($ma); 	
							}
							$inner_counter++;
						}
					}
					$final_arr[$count] = $temp_multi_arr;
					$count++;	
				}
			}
		}
		return $final_arr;
		
	}
	
	/**
	*	@desc This function is used to manually decode the json data for sort order. This was done as the php build in json_decode failed to decode the multi level json string. 
	*
	*   @name _manual_jason_decode
	*	@access private
	*	@param json(form elements)
	*	@return returns json decoded array 
	*/
	function _manual_jason_decode_sort_order($data)
	{
		$temp_arr = array();
		$final_arr = array();
		$count = 0;
		$separator = ',';
		if($data){	
			$temp_arr = explode($separator,$data);
			//echo '<pre>'.print_r($temp_arr,true).'</pre>';
			$multi_arr = array();
			foreach($temp_arr as $arr){
				$multi_arr = json_decode($arr);
				$final_arr[$multi_arr->name] = $count;
				$count++;
			}

		}
		return $final_arr;
		
	}
	
	/**
	*	@desc Checks if an attribute can have multiple value
	*
	*   @name has_multiple_value
	*	@access public
	*	@param (string) name of the attribute
	*	@return return true if an attribute can have multiple value otherwise it returns false
	*/
	function has_multiple_value($attribute_name)
	{
		$attribute_info = $this->formbuilder_model->get_attribute_info($attribute_name);
		return  ($attribute_info->multi_select == 'yes' ? true : false);

	}

}