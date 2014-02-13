<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Ajax
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('client_model');
		$this->load->model('user/user_model');
	}
	
	function add_client() {
		$data = $this->input->post();
		
		$user_data = array(
			'status' => $data['status'],
			'is_admin' => 0,
			'is_staff' => 0,
			'is_client' => 1,
			'email_address' => $data['email_address'],
			'username' => $data['email_address'],
			'full_name' => $data['full_name'],
			'address' => $data['address'],
			'suburb' => $data['suburb'],
			'city' => $data['city'],
			'state' => $data['state'],
			'postcode' => $data['postcode'],
			'country' => $data['country'],
			'phone' => $data['phone']
		);
		
		$user_id = $this->user_model->insert_user($user_data);
		
		$client_data = array(
			'user_id' => $user_id,
			'external_client_id' => $data['external_client_id'],
			'company_name' => $data['company_name'],
			'abn' => $data['abn']
		);
		$client_id = $this->client_model->insert_client($client_data);
		echo $user_id;
	}
	
	function search_clients()
	{
		$data['clients'] = $this->client_model->search_clients($this->input->post('keyword'));
		$this->load->view('search_results', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: update_client
	*	@desc: abstract function to update client profile
	*	@access: public
	*	@param: (int) $user_id, (string) $tab
	*	@return: (view) of different update form depends on selected tab
	*/
	function update_client($user_id, $tab)
	{
		$data['client'] = $this->client_model->get_client($user_id);
		$this->load->view('edit_' . $tab, isset($data) ? $data : NULL);
	}
	
	function update_details()
	{
		$data = $this->input->post();
		$user_data = array(
			'status' => $data['status'],
			'email_address' => $data['email_address'],
			'password' => $data['password'],
			'full_name' => $data['full_name'],
			'address' => $data['address'],
			'suburb' => $data['suburb'],
			'city' => $data['city'],
			'state' => $data['state'],
			'postcode' => $data['postcode'],
			'country' => $data['country'],
			'phone' => $data['phone'],
			'modified_on' => date('Y-m-d H:i:s')
		);
		$this->user_model->update_user($data['user_id'], $user_data);
		$client_data = array(
			'external_client_id' => $data['external_client_id'],
			'company_name' => $data['company_name'],
			'abn' => $data['abn']
		);
		$this->client_model->update_client($data['user_id'], $client_data);
		
	}
}