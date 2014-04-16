<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_photo extends MX_Controller {

	var $user = null;
	var $is_client = false;
	function __construct()
	{
		parent::__construct();
		$this->load->model('staff_model');
		$this->user = $this->session->userdata('user_data');
		$this->is_client = modules::run('auth/is_client');
	}	
	
	/**
	*	@name: load_picture
	*	@desc: show the profile picture and gallery
	*	@access: public
	*	@param: (via POST) (int) user_id
	*	
	*/
	function load_staff_photos()
	{
		$user_id = $this->input->post('user_id',true);
		$photos = $this->staff_model->get_all_photos($user_id);
		$data['photos'] = $photos;
		$data['user_id'] = $user_id;				
		$this->load->view('client/staff_photos_list', isset($data) ? $data : NULL);
	}
	
}
