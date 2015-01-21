<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller {

	var $user = null;
	function __construct()
	{
		parent::__construct();
		$this->user = $this->session->userdata('user_data');
		$this->load->model('sms_model');
	}

	function load_template() {
		$template_id = $this->input->post('template_id');
		$data['template'] = $this->sms_model->get_template($template_id);
		$this->load->view('template_form', isset($data) ? $data : NULL);
	}

	function update_template() {
		$input = $this->input->post();
		$template_id = $input['template_id'];
		if (!isset($input['status'])) {
			$input['status'] = 0;
		} else {
			$input['status'] = 1;
		}
		$this->sms_model->update_template($template_id, $input);
	}

	function list_receivers() {
		$user_ids = explode(',', $this->input->post('user_ids'));
		$users = array();
		if(count($user_ids) > 0){
			foreach($user_ids as $user_id) {
				$users[] = modules::run('user/get_user', $user_id);
			}
		}
		$data['users'] = $users;
		$this->load->view('receivers_list_view', isset($data) ? $data : NULL);
	}

	function send_general_sms() {
		$user_ids = explode(',', $this->input->post('selected_user_ids'));
		if (count($user_ids) > modules::run('account/get_credits', 'sms')) {
			echo json_encode(array('ok' => false, 'msg' => 'Insufficient credits'));
			return;
		}
		error_reporting(0);
		$count = 0;
		if (count($user_ids) > 0) {
			foreach($user_ids as $user_id) {
				$user = modules::run('user/get_user', $user_id);
				$to = mobile_format($user['mobile']);
				$msg = $this->input->post('msg');
				modules::run('sms/send_2ways_sms', $to, $msg);
				$count++;
			}
		}
		# Take the credits out
		$this->load->model('account/account_model');
		$this->account_model->deduct_credits('sms', $count);

		echo json_encode(array('ok' => true));
	}

	function send_shift_request_sms() {
		$this->load->model('sms_master_model');
		$this->load->model('job/job_shift_model');
		$shift_ids = explode(',', $this->input->post('selected_shift_ids'));

		if (count($shift_ids) > modules::run('account/get_credits', 'sms')) {
			echo json_encode(array('ok' => false, 'msg' => 'Insufficient credits'));
			return;
		}
		error_reporting(0);
		$count = 0;
		if(count($shift_ids) > 0){
			foreach($shift_ids as $shift_id) {
				$shift = modules::run('job/shift/get_shift', $shift_id);
				if ($shift['staff_id']) {
					$user = modules::run('user/get_user', $shift['staff_id']);
					$to = mobile_format($user['mobile']);
					$msg = $this->input->post('msg');
					$msg = str_replace('{FirstName}', $user['first_name'], $msg);
					$role = modules::run('attribute/role/display_role', $shift['role_id']);
					$venue = modules::run('attribute/venue/display_venue', $shift['venue_id']);
					$code = $this->sms_master_model->get_largest_code();
					$msg = str_replace('{Role}', $role, $msg);
					$msg = str_replace('{Venue}', $venue, $msg);
					$msg = str_replace('{Date}', date('d/m/Y', $shift['start_time']), $msg);
					$msg = str_replace('{StartTime}', date('H:i', $shift['start_time']), $msg);
					$msg = str_replace('{FinishTime}', date('H:i', $shift['finish_time']), $msg);
					$msg = str_replace('{Code}', $code, $msg);
					$company = modules::run('setting/company_profile');
					$msg = str_replace('{CompanyName}', $company['company_name'], $msg);

					$result = modules::run('sms/send_2ways_sms', $to, $msg);

					$count++;


					if (is_array($result)) {
						$subdomain = array_shift(explode(".",$_SERVER['HTTP_HOST']));
						$data = array(
							'msg_id' => $result[0],
							'code' => $code,
							'subdomain' => $subdomain,
							'shift_id' => $shift_id,
							'user_id' => $user['user_id'],
							'receiver' => $to
						);
						$this->sms_master_model->insert_request($data);
						$this->job_shift_model->update_job_shift($shift_id, array(
							'sms_sent' => 1,
							'sms_sent_on' => date('Y-m-d H:i:s')
						));
					}
				}
			}
		}
		# Take the credits out
		$this->load->model('account/account_model');
		$this->account_model->deduct_credits('sms', $count);

		echo json_encode(array('ok' => true));

	}

	function calculate_amount()
	{
		$credits = $this->input->post('credits');
		if (!is_numeric($credits))
		{
			return;
		}

		$data['credits'] = $credits;
		$this->load->view('purchase_summary_view', isset($data) ? $data : NULL);
	}

	function buy_credits()
	{
		$input = $this->input->post();
		$credits = $input['credits'];
		if (!is_numeric($credits))
		{
			echo 'invalid credits';
			return;
		}

		$total = SMS_PRICE * $credits;
		$total *= 1.1; # GST


		# Record order
		$order = array(
			'credit_type' => 'sms',
			'credits' => $credits,
			'total_amount' => $total,
			'firstname' => $input['firstname'],
			'lastname' => $input['lastname'],
			'address' => $input['address'],
			'city' => $input['city'],
			'state' => $input['state'],
			'postcode' => $input['postcode'],
			'country' => $input['country'],
			'ccname' => $input['ccname'],
			'ccnumber' => substr($input['ccnumber'], 0 ,4),
			'expmonth' => $input['expmonth'],
			'expyear' => $input['expyear'],
			'ccv' => $input['ccv']
		);
		$this->load->model('account/account_model');
		$order_id = $this->account_model->create_order($order);


		$total = money_format('%i',$total); # Money format the total
		$total = str_replace('.','',$total); # Money in cent

		$result = $this->process_eWay($order_id, $order['firstname'], $order['lastname'], $this->user['email_address'], $order['address'] . ', ' . $order['city'] . ' ' . $order['state'], $order['postcode'], $order['ccname'], $input['ccnumber'], $order['expmonth'], $order['expyear'], $order['ccv'], $total);

		$this->account_model->update_order($order_id, array('result' => $result));

		if ($result) # Successful transaction
		{
			# Add credits
			$this->account_model->add_credits('sms', $credits);
			# Send the receipt
			$order['purchase_id'] = 'SBSMS' . $this->user['user_id'] . '-' . $order_id;
			$this->send_receipt_email($order);
			echo 'true';
		}
		else
		{
			echo 'false';
		}
	}

	function process_eWay($order_id,$firstname,$lastname,$email,$address,$postcode,$cardname,$cardnumber,$expmonth,$expyear,$cvv,$total) {
		# Payment config
		#$total = 1000; # Just for testing

		#$eWAY_CustomerID = "87654321"; // eWAY Customer ID
		$eWAY_CustomerID = "12229578"; // eWAY Propagate
		$eWAY_PaymentMethod = 'REAL_TIME_CVN'; // payment gatway to use (REAL_TIME, REAL_TIME_CVN or GEO_IP_ANTI_FRAUD)
		$eWAY_UseLive = true; // true to use the live gateway

		$this->load->model('Eway_model');
		$this->Eway_model->init($eWAY_CustomerID, $eWAY_PaymentMethod, $eWAY_UseLive);

		# Set the payment details
		$this->Eway_model->setTransactionData("TotalAmount", $total); //mandatory field
		$this->Eway_model->setTransactionData("CustomerFirstName", $firstname);
		$this->Eway_model->setTransactionData("CustomerLastName", $lastname);
		$this->Eway_model->setTransactionData("CustomerEmail", $email);
		$this->Eway_model->setTransactionData("CustomerAddress", $address);
		$this->Eway_model->setTransactionData("CustomerPostcode", $postcode);
		$this->Eway_model->setTransactionData("CustomerInvoiceDescription", "StaffBooks");
		$this->Eway_model->setTransactionData("CustomerInvoiceRef", "INV" . $order_id); # Order reference
		$this->Eway_model->setTransactionData("CardHoldersName", $cardname); # mandatory field
		$this->Eway_model->setTransactionData("CardNumber", $cardnumber); # mandatory field
		$this->Eway_model->setTransactionData("CardExpiryMonth", $expmonth); # mandatory field
		$this->Eway_model->setTransactionData("CardExpiryYear", $expyear); # mandatory field
		$this->Eway_model->setTransactionData("TrxnNumber", "SBSMS" . $order_id);
		$this->Eway_model->setTransactionData("Option1", "");
		$this->Eway_model->setTransactionData("Option2", "");
		$this->Eway_model->setTransactionData("Option3", "");
		$this->Eway_model->setTransactionData("CVN", $cvv);
		$this->Eway_model->setCurlPreferences(CURLOPT_SSL_VERIFYPEER, 0); // Require for Windows hosting

		$ewayResponseFields = $this->Eway_model->doPayment();

		if (strtolower($ewayResponseFields["EWAYTRXNSTATUS"])=="false") {
			$this->session->set_userdata('eway_msg', $ewayResponseFields["EWAYTRXNERROR"]);
			return false;
		}

		else if (strtolower($ewayResponseFields["EWAYTRXNSTATUS"])=="true") {
			return true;
		}
		else {
			$this->session->set_userdata('eway_msg', "Error: An invalid response was recieved from the payment gateway.");
			return false;
		}
	}

	function send_receipt_email($order)
	{
		$message = $this->load->view('account/receipt_email_view', isset($order) ? $order : NULL, true);
		modules::run('email/send_email', array(
			'to' => $this->user['email_address'],
			'from' => SMTEAM_EMAIL,
			'from_text' => 'StaffBooks',
			'subject' => 'Your Order Receipt',
			'message' => $message,
			'overwrite' => true
		));
	}
}
