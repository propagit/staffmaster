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
		$input = $this->input->post();
		if (!$input['company_name']) {
			echo json_encode(array('ok' => false, 'error_id' => 'company_name', 'msg' => 'Company name is required'));
			return;
		}
		if (!$input['email_address'] || !valid_email($input['email_address'])) {
			echo json_encode(array('ok' => false, 'error_id' => 'email_address', 'msg' => 'Invalid email address'));
			return;
		}
		if ($this->user_model->check_user_email($input['email_address'])) {
			echo json_encode(array('ok' => false, 'error_id' => 'email_address', 'msg' => 'Email address is already used!'));
			return;
		}
		if (!$input['password']) {
			echo json_encode(array('ok' => false, 'error_id' => 'password', 'msg' => 'Password is required'));
			return;
		}
		$user_data = array(
			'status' => $input['status'],
			'is_admin' => 0,
			'is_staff' => 0,
			'is_client' => 1,
			'email_address' => $input['email_address'],
			'username' => $input['email_address'],
			'full_name' => $input['full_name'],
			'address' => $input['address'],
			'suburb' => $input['suburb'],
			'city' => $input['city'],
			'state' => $input['state'],
			'postcode' => $input['postcode'],
			'country' => $input['country'],
			'phone' => $input['phone']
		);
		
		$user_id = $this->user_model->insert_user($user_data);
		
		$client_data = array(
			'user_id' => $user_id,
			'external_client_id' => $input['external_client_id'],
			'company_name' => $input['company_name'],
			'abn' => $input['abn']
		);
		$client_id = $this->client_model->insert_client($client_data);
		echo json_encode(array('ok' => true, 'user_id' => $user_id));
	}
	
	function search_clients()
	{
		$data['clients'] = $this->client_model->search_clients($this->input->post());
		$data['total_clients'] = $this->client_model->search_clients($this->input->post(),true);
		$data['current_page'] = $this->input->post('current_page',true);
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
		$input = $this->input->post();
		if (!$input['company_name']) {
			echo json_encode(array('ok' => false, 'error_id' => 'company_name', 'msg' => 'Company name is required'));
			return;
		}
		if (!$input['email_address'] || !valid_email($input['email_address'])) {
			echo json_encode(array('ok' => false, 'error_id' => 'email_address', 'msg' => 'Invalid email address'));
			return;
		}
		if ($this->user_model->check_user_email($input['email_address'], $input['user_id'])) {
			echo json_encode(array('ok' => false, 'error_id' => 'email_address', 'msg' => 'Email address is already used!'));
			return;
		}
		
		$data = $this->input->post();
		$user_data = array(
			'status' => $data['status'],
			'email_address' => $data['email_address'],
			'username' => $data['email_address'],
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
		
		# check if the external staff id is unique
		if ($data['external_client_id'] != '' && $this->client_model->check_external_id($data['external_client_id'], $data['user_id'])) {
			echo json_encode(array('ok' => true));
		}
		
		echo json_encode(array('ok' => true));
	}
	
	function add_department()
	{
		$data = $this->input->post();
		$this->client_model->insert_client_department($data);
	}
	
	function list_departments()
	{
		$user_id = $this->input->post('user_id');
		$data['departments'] = $this->client_model->get_client_departments($user_id);
		$this->load->view('deparments_list', isset($data) ? $data : NULL);
	}
	
	function edit_department($department_id) {
		$data['department'] = $this->client_model->get_client_department($department_id);
		$this->load->view('department_edit_form', isset($data) ? $data : NULL);
	}
	function update_department() {
		$data = $this->input->post();
		$this->client_model->update_department($data['department_id'], $data);
	}
	
	function get_venues() {
		$user_id = $this->input->post('user_id');
		$data['venues'] = $this->client_model->get_venues($user_id);
		$data['user_id'] = $user_id;
		$this->load->view('venues_list', isset($data) ? $data : NULL);
	}
	
	function restrict_venue() {
		$input = $this->input->post();
		$this->client_model->restrict_venue($input);
	}
	
	function unrestrict_all() {
		$user_id = $this->input->post('user_id');
		$unrestrict_all = $this->input->post('unrestrict_all');
		if ($unrestrict_all == 'false') { # Restrict all venues
			$venues = modules::run('attribute/venue/get_venues');
			foreach($venues as $venue) {
				$this->client_model->add_venue(array(
					'user_id' => $user_id, 
					'venue_id' => $venue['venue_id']));
			}
		} else { # Unrestrict all venues / Delete all venues from restrict list
			$this->client_model->delete_venues($user_id);
		}
	}
	
	/**
	*	@name: delete_client
	*	@desc: Delete single client
	*	@access: public
	*	@param: (via POST) user id
	*	
	*/
	function delete_client()
	{
		$user_id = $this->input->post('user_id',true);
		$this->client_model->delete_client($user_id);	
	}
	/**
	*	@name: delete_multi_clients
	*	@desc: Delete multiple clients
	*	@access: public
	*	@param: (via POST) user id
	*	
	*/
	function delete_multi_clients()
	{
		$user_ids = $this->input->post('user_client_selected_user_id');
		return $this->user_model->delete_multi_users(implode(',',$user_ids));
	}
	/**
	*	@name: update_status_multi_clients
	*	@desc: Update rating for multiple clients
	*	@access: public
	*	@param: (via POST) user id and new rating
	*	
	*/
	function update_status_multi_clients()
	{
		$user_ids = $this->input->post('user_client_selected_user_id',true);
		$new_status = $this->input->post('new_multi_status',true);
		return $this->user_model->update_status_multi_users(implode(',',$user_ids),$new_status);
	}
	
	function load_export_modal($user_ids='')
	{
		$data['user_ids'] = $user_ids;
		$this->load->view('export_modal_view', isset($data) ? $data : NULL);
	}
	
	function exporting()
	{
		$user_ids = $this->input->post('user_ids');
		$user_ids = explode('~', $user_ids);
		$export_id = $this->input->post('export_id');
		if ($export_id == '') {
			return;
		}
		
		$file_name = $this->_export_clients($user_ids, $export_id);
		echo $file_name;
	}
	
	private function _export_clients($user_ids, $export_id) 
	{
		$fields = modules::run('export/get_fields', $export_id);
		
		ini_set('memory_limit', '128M');
		ini_set('max_execution_time', 3600); //300 seconds = 5 minutes
		
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("StaffBooks");
		$objPHPExcel->getProperties()->setLastModifiedBy("StaffBooks");
		$objPHPExcel->getProperties()->setTitle("Client Data");
		$objPHPExcel->getProperties()->setSubject("Client Data");
		$objPHPExcel->getProperties()->setDescription("Client Data Excel file, generated from StaffBooks.");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$i = 0;
		$row = 1;
		foreach($fields as $field) {
			if ($i < 26)
			{
				$letter = chr(97 + $i) . $row;
			}
			else
			{
				$letter = 'A' . chr(97 + ($i-26)) . $row;
			}
			$objPHPExcel->getActiveSheet()->SetCellValue($letter, $field['title']);
			$i++;
		}
		$i = 0;
		foreach($user_ids as $user_id) {
			$client = $this->client_model->get_client($user_id);
			$row++;
			foreach($fields as $field) {
				$is_string = false;
				$value = $field['value']; # Convert $field, $timesheet
				
				if (strpos($value,'phone') !== false) 
				{
					$is_string = true;
				}
				
				$value = str_replace('{internal_id}', $client['user_id'], $value);
				$value = str_replace('{company_name}', $client['company_name'], $value);
				$value = str_replace('{contact_name}', $client['full_name'], $value);
				$value = str_replace('{address}', $client['address'], $value);
				$value = str_replace('{suburb}', $client['suburb'], $value);
				$value = str_replace('{city}', $client['city'], $value);
				$value = str_replace('{postcode}', $client['postcode'], $value);
				$value = str_replace('{state}', $client['state'], $value);
				$value = str_replace('{country}', $client['country'], $value);
				$value = str_replace('{email}', $client['email_address'], $value);
				$value = str_replace('{phone}', $client['phone'], $value);
				$value = str_replace('{abn}', $client['abn'], $value);
				$value = str_replace('{external_id}', $client['external_client_id'], $value);
				
				#$value = str_replace('{joined_date}', date('d/m/Y', strtotime($client['created_on'])), $value);
				
				if ($i < 26)
				{
					$letter = chr(97 + $i) . $row;
				}
				else
				{
					$letter = 'A' . chr(97 + ($i-26)) . $row;
				}
				if ($is_string) 
				{
					$objPHPExcel->getActiveSheet()->getStyle($letter)->getNumberFormat()->setFormatCode('@');
					$objPHPExcel->getActiveSheet()->getCell($letter)->setValueExplicit($value, PHPExcel_Cell_DataType::TYPE_STRING);
				}
				else
				{
					$objPHPExcel->getActiveSheet()->SetCellValue($letter, $value);
				}
				
				$i++;
			}
			$i=0;
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('client');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "CSV");
		$file_name = 'client_' . time() . ".csv";
		
		$dir = EXPORTS_PATH . "/client";
		if(!is_dir($dir))
		{
			mkdir($dir);
			chmod($dir,0777);
			$fp = fopen($dir.'/index.html', 'w');
			fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
			fclose($fp);
		}
		
		$objWriter->save(EXPORTS_PATH . "/client/" . $file_name);
		return $file_name;
	}
	
	/**
	*	@name: send_email
	*	@desc: Send email to a particular email vai send email modal window UI. 
	*	@access: private
	*	@param: (via POST)
	*	
	*/
	function send_email()
	{
		$this->load->model('setting/setting_model');
		$this->load->model('email/email_template_model');
		//get company profile
		$company = $this->setting_model->get_profile();	
		//get post data
		$email_body = $this->input->post('email_body');
		$selected_user_ids = $this->input->post('selected_user_ids',true);
		$email_template_id = $this->input->post('email_template_select',true);
		
		if($email_template_id){
			$template_info = $this->email_template_model->get_template($email_template_id);
			$email_subject = $template_info->email_subject;
		}
		
		if($selected_user_ids){
			//create obj parameters based on user and email template eg
			$user_ids = json_decode($selected_user_ids);
			foreach($user_ids as $user_id){
				$send_email = true;
				if($send_email){
					$email = $this->user_model->get_user_email_from_user_id($user_id);
					//get receiver obj
					$email_obj_params = array(
									'template_id' => $email_template_id,
									'user_id' => $user_id,
									'company' => $company
								);
					$obj = modules::run('email/get_email_obj',$email_obj_params);
					if($email){
						$email_data = array(
									'to' => $email,
									'from' => $template_info->email_from,
									'from_text' => $company['email_c_name'],
									'subject' => modules::run('email/format_template_body',$template_info->email_subject,$obj),
									'message' => modules::run('email/format_template_body',$email_body,$obj)
								);
						modules::run('email/send_email',$email_data);
					}
				}
			}
		}
		$this->session->unset_userdata('selected_user_ids');
		echo 'success';
	}
	
}