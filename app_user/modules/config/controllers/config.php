<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Product
 * @author: namnd86@gmail.com
 */

class Config extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('config_model');
		$this->load->model('user/user_model');
	}
	
	public function index()
	{
		if ($this->input->post('upload_logo'))
		{
			$data['result'] = $this->upload_logo();
		}
		if ($this->input->post('colour_primary'))
		{
			$data['colours'] = $this->update_colours();
		}
		$data['user'] = $this->session->userdata('user_data');
		$this->load->view('config', isset($data) ? $data : NULL);
	}
	
	function shipping_cost()
	{
		$cost = $this->config_model->get_config('shipping_cost');
		echo $cost['config_value'];
	}

	function upload_logo()
	{
		$config['upload_path'] = './uploads/logos/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '2048';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('logo'))
		{
			return array(
				'status' => false,
				'message' => $this->upload->display_errors('','')
			);
		}
		else
		{
			$logo = $this->upload->data();
			$user = $this->session->userdata('user_data');
			if (file_exists('./uploads/logos/' . $user['logo_url']))
			{
				#unlink('./uploads/logos/' . $user['logo_url']);
			}
			$user['logo_url'] = $logo['file_name'];
			$this->user_model->update_user($user['user_id'], array('logo_url' => $logo['file_name']));
			$this->session->set_userdata('user_data', $user);
			return array(
				'status' => true,
				'message' => 'Your logo has been updated successfully'
			);
		}
	}
	
	function update_colours()
	{
		$user = $this->session->userdata('user_data');
		
		$data = array(
			'colour_primary' => ($_POST['colour_primary']) ? $_POST['colour_primary'] : COLOR_PRIM,
			'colour_secondary' => ($_POST['colour_secondary']) ? $_POST['colour_secondary'] : COLOR_SECO,
			'colour_highlight' => ($_POST['colour_highlight']) ? $_POST['colour_highlight'] : COLOR_HILI,
			'colour_midtone' => ($_POST['colour_midtone']) ? $_POST['colour_midtone'] : COLOR_MIDT,
			'colour_dark' => ($_POST['colour_dark']) ? $_POST['colour_dark'] : COLOR_DARK
		);
		foreach($data as $key => $value)
		{
			$user[$key] = $value;
		}
		if ($this->user_model->update_user($user['user_id'], $data))
		{
			$this->session->set_userdata('user_data', $user);
			return array(
				'status' => true,
				'message' => 'Your colours has been updated successfully'
			);
		}
	}
}