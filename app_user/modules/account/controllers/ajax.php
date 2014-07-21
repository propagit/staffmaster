<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller {
	
	var $user = null;
	function __construct()
	{
		parent::__construct();
		$this->user = $this->session->userdata('user_data');
	}
	
	function calculate_amount()
	{
		$credits = $this->input->post('credits');
		if (!is_numeric($credits))
		{
			return;
		}
		$this->load->model('account_master_model');
		$data['price'] = $this->account_master_model->get_price($credits);
		$data['credits'] = $credits;
		$this->load->view('purchase_summary_view', isset($data) ? $data : NULL);
	}
	
	function validate_form()
	{
		$input = $this->input->post();
		foreach($input as $key => $value)
		{
			if (!$value)
			{
				echo json_encode(array('ok' => false, 'error_id' => $key));
				return;
			}
		}
		echo json_encode(array('ok' => true));
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
		$this->load->model('account_master_model');
		$price = $this->account_master_model->get_price($credits);
		if (!$price)
		{
			echo 'system error';
			return;
		}
		$total = $price['unit_price'] * $credits;
		$total *= 1.1; # GST
		
		
		# Record order		
		$order = array(
			'credit_type' => 'system',
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
		$this->load->model('account_model');
		$order_id = $this->account_model->create_order($order);
		
		
		$total = money_format('%i',$total); # Money format the total
		$total = str_replace('.','',$total); # Money in cent
		
		$result = $this->process_eWay($order_id, $order['firstname'], $order['lastname'], $this->user['email_address'], $order['address'] . ', ' . $order['city'] . ' ' . $order['state'], $order['postcode'], $order['ccname'], $input['ccnumber'], $order['expmonth'], $order['expyear'], $order['ccv'], $total);
		
		$this->account_model->update_order($order_id, array('result' => $result));
		
		if ($result) # Successful transaction
		{
			# Add credits
			$this->account_model->add_credits('system', $credits);
			# Send the receipt
			$order['purchase_id'] = 'SBSYS-' . $this->user['user_id'] . '-' . $order_id;
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
		$this->Eway_model->setTransactionData("TrxnNumber", "TRXN" . $purchase_id); 
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
			print "Error: An invalid response was recieved from the payment gateway.";
			return false;
		}		
	}
	
	function send_receipt_email($order)
	{
		$message = $this->load->view('receipt_email_view', isset($order) ? $order : NULL, true);
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