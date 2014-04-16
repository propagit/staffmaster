<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Custom_styles extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('setting/setting_model');
	}
	
	/**
	*	@name: index
	*	@desc: Main view to change system styles
	*	@access: public
	*	@param: (null)
	*	@return: Loads view to change system styles
	*/
	function index()
	{
		$data['styles'] = array(
							'primary_colour' => COLOUR_PRIM,
							'rollover_colour' => COLOUR_ROLL,
							'secondary_colour' => COLOUR_SECO,
							'text_colour' => TEXT_COLOUR
							);
		$current_styles = $this->setting_model->get_system_styles(1);
		if($current_styles){
			$data['styles'] = $current_styles;	
		}
		$this->load->view('custom_styles', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: hex_2_rgb
	*	@desc: This function changes hex value to RBG value
	*	@access: public
	*	@param: ([var char] hex value)
	*	@return: returns rbg array
	*/
    function hex_2_rgb($hex) 
    {
	   $hex = str_replace("#", "", $hex);
	
	   if(strlen($hex) == 3) {
		  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
		  $r = hexdec(substr($hex,0,2));
		  $g = hexdec(substr($hex,2,2));
		  $b = hexdec(substr($hex,4,2));
	   }
	   $rgb = array($r, $g, $b);
	   //return implode(",", $rgb); // returns the rgb values separated by commas
	   return $rgb; // returns an array with the rgb values
    }
	
}