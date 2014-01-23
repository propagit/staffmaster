<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Common
 * @author: namnd86@gmail.com
 */

class Common extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('common_model');
	}
	
	function dropdown_actions($field_name, $field_value=null)
	{
		$this->load->view('dropdown_actions', isset($data) ? $data : NULL);
	}
	
	function dropdown_status($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_status', isset($data) ? $data : NULL);
	}
		
	function list_supers()
	{
		$supers = $this->common_model->get_supers();
		foreach($supers as $super) { echo '"' . $super['name'] . '",'; } 
	}
	
	function check_super($name)
	{
		$supers = $this->common_model->get_supers();
		$found = false;
		foreach($supers as $super)
		{
			if ($super['name'] == $name)
			{
				$found = true;
			}
		}
		return $found;
	}
	
	function dropdown_states($field_name, $field_value=null)
	{
		$data['states'] = $this->common_model->get_states();
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_states', isset($data) ? $data : NULL);
	}
	
	function dropdown_countries($field_name, $field_value=null)
	{
		$data['countries'] = $this->common_model->get_countries();
		$data['field_name'] = $field_name;
		if ($field_value == null || $field_value=='')
		{
			$field_value = 'AU';
		}
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_countries', isset($data) ? $data : NULL);
	}
	
	function dropdown_titles($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_titles', isset($data) ? $data : NULL);
	}
	
	function dropdown_genders($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_genders', isset($data) ? $data : NULL);
	}
	
	function dropdown_dob($day=null, $month=null, $year=null)
	{
		$data['day'] = $day;
		$data['month'] = $month;
		$data['year'] = $year;
		$this->load->view('dropdown_dob', isset($data) ? $data : NULL);
	}
	
	function break_time($string)
	{
		$a = json_decode($string);
		
		if (count($a) > 0) 
		{
			$total = 0;
			foreach($a as $break)
			{
				$total += $break->length;
			}
			echo $total/60 . ' mins';
		}
		else
		{
			echo 0;
		}
	}
	function dropdown_location($field_name, $field_value=null)
	{

		$data['locations'] = $this->common_model->get_locations();
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_location', isset($data) ? $data : NULL);
	}
	function dropdown_location_form($field_name, $field_value=null)
	{
		$data['locations'] = $this->common_model->get_locations();
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_location_form', isset($data) ? $data : NULL);
	}
	function dropdown_get_area()
	{
		
		$field_name = $this->input->post('field_name');
		$field_value = $this->input->post('field_value');
		$staff_locations = json_decode($field_value);
		$scs = array();
		foreach($staff_locations as $sc)
		{
			if($sc!=''){
			$scs[] = $sc;}
		}
		if(!isset($_POST['loc'])){$loc='';}else {$loc= $this->input->post('loc');}
		if($loc!=''){
			$new_loc = explode('#',$_POST['loc']);
			foreach($new_loc as $nl)
			{
				if($nl!=''){
				$scs[] = $nl;}
			}
		}
		$locats = $this->common_model->get_locations();
		//$areas = $this->common_model->get_locations_child($loc);
		//$detail = $this->common_model->get_locations_detail($loc);
		$print='';
		$select='';
		
		$print='<select data-placeholder="Select Your Area" class="selectMultiple" multiple="multiple" tabindex="6" >
			<option value=""></option>';
			
			foreach($locats as $lct)
			{
				//$detail = $this->common_model->get_locations_detail($lct['location_id']);
				$print.='<optgroup label="'.$lct['name'].'">';
				$areas = $this->common_model->get_locations_child($lct['location_id']);
				foreach($areas as $area)
				{
					if(in_array($area['location_id'],$scs)){$select=" selected=selected ";}else{$select='';}
					$print.='<option value="'.$area['location_id'].'"'.$select.'><b>'.$area['name'].'</b></option>';
					$areas2 = $this->common_model->get_locations_child($area['location_id']);
					foreach($areas2 as $ar)
					{	
						if(in_array($ar['location_id'],$scs)){$select=" selected=selected ";}else{$select='';}
						$print.='<option value="'.$ar['location_id'].'"'.$select.'>&nbsp;&nbsp;&nbsp;&nbsp;'.$ar['name'].'</option>';
					}
				}
				$print.='</optgroup>';
			}
		$print.='</select> <script>	$(".select").select2();	$(".selectMultiple").select2();</script>';
		
		
		echo $print;
	}
	function dropdown_get_area_state()
	{				
		$loc= $this->input->post('loc');
		$field_name = $this->input->post('field_name');
		$field_value = $this->input->post('field_value');
		$staff_locations = json_decode($field_value);
		$areas = $this->common_model->get_locations_child($loc);
		$detail = $this->common_model->get_locations_detail($loc);
		$print='';
		$select='';
		$print='<select name="area_location_state" id="area_location_state" class="form-control auto-width">
			<option value="">Select Area</option>';
			if($loc > 0){

			
				foreach($areas as $area)
				{
					//if(in_array($area['location_id'],$staff_locations)){$select=" selected=selected ";}
					$print.='<option value="'.$area['location_id'].'"'.$select.'>'.$area['name'].'</option>';
					
				}
			}
		$print.='</select>';
		
		
		echo $print;
	}
	
	function dropdown_form_get_area_state()
	{				
		$loc= $this->input->post('loc');
		$field_name = $this->input->post('field_name');
		$field_value = $this->input->post('field_value');
		$staff_locations = json_decode($field_value);
		$areas = $this->common_model->get_locations_child($loc);
		$detail = $this->common_model->get_locations_detail($loc);
		$print='';
		$select='';
		$print='<select name="'.$field_name.'" id="area_location_state" class="form-control auto-width">
			<option value="">Select Area</option>';
			if($loc > 0){

			
				foreach($areas as $area)
				{
					//if(in_array($area['location_id'],$staff_locations)){$select=" selected=selected ";}
					$print.='<option value="'.$area['location_id'].'"'.$select.'>'.$area['name'].'</option>';
					
				}
			}
		$print.='</select>';
		
		
		echo $print;
	}
	function dropdown_get_area_init()
	{

		$loc= $this->input->post('loc');
		$field_name = $this->input->post('field_name');
		$field_value = $this->input->post('field_value');
		$staff_locations = json_decode($field_value);
		$areas = $this->common_model->get_locations_child($loc);
		$detail = $this->common_model->get_locations_detail($loc);
		$print='';
		$select='';
		$print='<select data-placeholder="Select Your Area" class="selectMultiple" multiple="multiple" tabindex="6" >
			<option value=""></option>';
			if($loc > 0){
			$print.='<optgroup label="'.$detail['name'].'">';
			
				foreach($areas as $area)
				{
					if(in_array($area['location_id'],$staff_locations)){$select=" selected=selected ";}
					$print.='<option value="'.$area['location_id'].'"'.$select.'>'.$area['name'].'</option>';
					
				}
			}
		$print.='</optgroup></select> <script>	$(".select").select2();	$(".selectMultiple").select2();</script>';
		
		
		echo $print;
	}
	function define_area()
	{
		$loc='';
		$suburb = $this->input->post('suburb');
		$suburb = str_replace('&amp;','&',$suburb);

		$detail = $this->common_model->get_locations_byname($loc,$suburb);
		
		echo $detail['location_id'].'#';
		
	}
}