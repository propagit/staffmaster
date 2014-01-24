<?php

class Content extends MX_Controller {
	
	/**
	*	@class_desc Content controller. Controls most of the contents of the website including message sending, work showcase etc. 
	*	@class_comments Dependent on Content Model and Email Model.
	*	
	*
	*/

   function __construct()
	{
		parent::__construct();
		$this->load->model('Content_model');
		$this->load->model('Email_model');
	}

	
	/**
	*	@desc This is the landing page of the website
	*
	*   @name index
	*	@access public
	*	@param null
	*	@return loads home page
	*	
	*/
	
	
	function index()
	{
		$header['meta_data'] = array(
								'title' => 'Digital Studio Melbourne | Web Development & Website Design Company Melbourne',
								'desc' => 'Propagate Website Development and design, Hosting and Domain Services, Advertising and creative services studio',
								'keywords' => 'web development, web design, digital studio, melbourne digital studio, melbourne web development company, australian web development company'
								);
		$this->load->view('common/header',$header);
		$this->load->view('content/home');
		$this->load->view('common/footer');
	}
	
	/**
	*	@desc Subscribe to newsletter, sends newsletter subscription requested from the footer section of the website. The data is saved to the database and an email is sent to team@propagate.com.au
	*	
	*	@name subscribe
	*	@access public
	*	@param null
	*	@return Notifies the subscriber wheather the subscription has been successful or not. This message is shown to the user in a bootstrap modal.
	* 	@comments important comments
	*/

	function subscribe()
	{
		$valid = true;
		$msg = false;
		$email=$this->input->post('webpress');
		
		if($email){
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					$valid = false;	
				}
		}
		if($valid){
			$check = $this->Content_model->check_subscribe($email);
			if(count($check)==0){
				$data=array(
					'email' => $email,
					'date' =>date('Y-m-d H:i:s')
				);
				$this->Content_model->add_subscribe($data);
				
				//notify team		
				$to = team_email;
				//$to = "kaushtuvgurung@gmail.com";			
				$email_message = '<p>Hi Team <br /><br />
								  A new newsletter subscription was just received from Propagate website.</p>
							      <p>Subscriber\'s Email: '.$email.'
								  
								  <br /><br />
								  With Regards<br />
								  Propagate
								  </p>';
				
				$email_data = array(
								'to' => $to,
								'from_text' => 'Webpress - Propagate',
								'from' => $email,
								'subject' => 'New Newsletter Subscriber Alert',
								'message' => $email_message
								);
				$this->Email_model->send_email_v2($email_data);
				
				$msg = "Subscription Successful! Thank you for joining Web Press";
			}else{
				$msg = "This email address already exists in our system. Please try again with a different email address.";
			}
		}else{
			$msg = "Invalid email. Please try again with a valid email address";	
		}
		$this->session->set_flashdata('add_subscribe',$msg);
		redirect(base_url());
	}
	
	/**
	*	@desc This page showcases the projects undertaken by Propagate over the years. It contains slides of the projects mentioned in that secion with a brief description and an overview.
	*	
	*	@name ourwork
	*	@access public
	*	@param null
	*	@return loads our work page
	* 	@added_script has a custom javascript function that mimics the bootstrap carousel except the auto slide feature. This was added to showcase the projects on slides which then contained bootstrap carousel.
	*/
	
	function ourwork()
	{
		$header['meta_data'] = array(
								'title' => 'Our Work - Web Design, Web Application Development Australia',
								'desc' => 'Find the small collection of our most recent web projects throughout australia',
								'keywords' => 'our web development projects australia, web designs, web application development'
								);
		$this->load->view('common/header',$header);
		$this->load->view('content/our-work');
		$this->load->view('common/footer');
	}
	
	/**
	*	@desc Company
	*	
	*	@name company
	*	@access public
	*	@param null
	*	@return loads the company page
	* 
	*/
	
	function company()
	{
		$header['meta_data'] = array(
								'title' => 'Propagate Digital Melbourne - Web Application Desing and Development Company',
								'desc' => 'Founded in 2005 in Melbourne, the business has evolved to work in partnership with clients looking for a little more than just a web site. Our clients push the edge to create a competitive advantage for themselves, and so we push too.',
								'keywords' => 'propagate digital melbourne, digital company australia, web development company melbourne, web development company australia'
								);
		$this->load->view('common/header',$header);
		$this->load->view('content/company');
		$this->load->view('common/footer');
	}
	
	/**
	*	@desc Capabilities
	*	
	*	@name capabilities
	*	@access public
	*	@param null
	*	@return loads the capabilities page
	* 
	*/
	
	function capabilities()
	{
		$header['meta_data'] = array(
								'title' => 'Web Application Design and Development Capabilities',
								'desc' => 'We take pride in our methodology that has been polished over time to deliver on every project we undertake. We invest time at the outset to understand our clients and their businesses.',
								'keywords' => 'web development capabilities, web application development melbourne, digital agency melbourne'
								);
		$this->load->view('common/header',$header);
		$this->load->view('content/capabilities');
		$this->load->view('common/footer');
	}
	
	/**
	*	@desc Loads the process page. 
	*	
	*	@name process
	*	@access public
	*	@param null
	*	@return loads the process page
	*	@comments This page doesn't quite follow the default bootstrap grid layout and few custom css overwrites has been written to comply with the design template
	* 
	*/
	
	function process()
	{
		$header['meta_data'] = array(
								'title' => 'Web Application Development Process | Propagate Digital Agency Melbourne',
								'desc' => 'We deliver an amazing digital asset in the form of a custom built web site and online shopping experience.',
								'keywords' => 'propagate digital melbourne, digital company australia, web development company melbourne, web development process'
								);
		$this->load->view('common/header',$header);
		$this->load->view('content/process');
		$this->load->view('common/footer');
	}
	
	/**
	*	@desc Loads the contact us page. This page has three different contact form, 1. A simple contact us form, 2. A technical support form and 3. A project support form. The project support form adds a ticket to the WHMCS, the rest will simply email team@propagate.com.au.
	*	
	*	@name contact
	*	@access public
	*	@param null
	*	@return loads the contact us page
	*	 
	*/
	
	function contact()
	{
		$header['meta_data'] = array(
								'title' => 'Contact | Propagate Digital Agency Melbourne',
								'desc' => 'Got a new digital project you would like to discuss? Contact Propagate Digital Agency Melbourne',
								'keywords' => 'propagate digital melbourne, digital company australia, web development company melbourne, web development process, contact us'
								);
		$this->load->view('common/header',$header);
		$this->load->view('content/contact');
		$this->load->view('common/footer');
	}
	
	function web_apps($web_app = "")
	{
		$header['meta_data'] = array(
								'title' => 'Web Application Development | Propagate Digital Agency Melbourne',
								'desc' => 'Propagate digital has developed cutting edge web application for casual staff management and online marketing tools that everyone loves.',
								'keywords' => 'online email marketing tools, online staff management application, online survey creator, online sms marketing system'
								);
		$this->load->view('common/header',$header);
		$this->load->view('content/web_apps');
		$this->load->view('common/footer');
	}
	
	function ecommerce()
	{
		$header['meta_data'] = array(
								'title' => 'E-Commernce - Content Management System | Propagate Digital Agency Melbourne',
								'desc' => 'Since inception Propagate has been creating custom function to support our clients business objectives, this has lead to us building a module based CMS and eCommerce platform we call FlareRetail.',
								'keywords' => 'custom content management system, online shopping cart management system, content management system'
								);
		$this->load->view('common/header',$header);
		$this->load->view('content/ecommerce');
		$this->load->view('common/footer');
	}
	
	function _cms()
	{
		$this->load->view('common/header');
		$this->load->view('content/cms');
		$this->load->view('common/footer');
	}
	
	function responsive()
	{
		$header['meta_data'] = array(
								'title' => 'Responsive - Mobile Sites | Propagate Digital Agency Melbourne',
								'desc' => 'Responsive web development undertaken by propagate digital. Why it is a must for a website to be responsive?',
								'keywords' => 'responsive web design melbourne, responsive web design australia, responsive web development melbourne, responsive web development australia'
								);
		$this->load->view('common/header',$header);
		$this->load->view('content/responsive');
		$this->load->view('common/footer');
	}
	
	function seo()
	{
		$header['meta_data'] = array(
								'title' => 'Search Engine Optimisation - Search Engine Marketing',
								'desc' => 'Propagate digital offers wide range of services related to search engine optimisation and search engine marketing. Contact us for more.',
								'keywords' => 'search engine optimisation, search engine marketing melbourne, search engine optimisation melbourne'
								);
		$this->load->view('common/header',$header);
		$this->load->view('content/seo');
		$this->load->view('common/footer');
	}
	
	function social()
	{
		$header['meta_data'] = array(
								'title' => 'Social - Viral Online Customer Engagement',
								'desc' => 'Propagate digital offers social media marketing which helps expand the business presence in the web.',
								'keywords' => 'social media marketing, social media marketing comapany melbourne, social media marketing company australia'
								);
		$this->load->view('common/header',$header);
		$this->load->view('content/social');
		$this->load->view('common/footer');
	}
	
	function page_not_found()
	{
		$header['meta_data'] = array(
								'title' => '404 Page Not Found',
								'desc' => 'Page Not Found',
								'keywords' => ''
								);
		$this->load->view('common/header',$header);
		$this->load->view('content/page_not_found');
		$this->load->view('common/footer');
	}
	
	function _test()
	{
		$this->session->set_flashdata('sent',true);
		$this->session->set_flashdata('error',true);
		redirect('contact');
	}
	
	
	
	
	function sendmsg_contact() 
	{
		$name = $this->input->post('name',true);
		$email = $this->input->post('email',true);
		$phone = $this->input->post('phone',true);
		//$budget = $this->input->post('budget',true);
		$message = $this->input->post('message',true);
		$contact_validator = $this->input->post('contact_validator',true);
		$valid = true;
		
		if($contact_validator == ''){
			if(!$name && !$email && !$phone && !$message){
				$valid = false;	
			}
		
			if($email){
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					$valid = false;	
				}
			}
	
			$from = $email;
			$from_text = 'Touch Base - Propagate';
			$subject = 'New Touch Base Message Alert';
			if($valid){
				
				$to = team_email;
				//$to = 'kaushtuv@propagate.com.au';
				$email_message = '<p>A general inquery was received from touch base section of Propagate website. The details are listed below. </p>
							
							<p>
							Name: '.$name.'<br />
							Email: '.$email.'<br />
							Phone: '.$phone.'<br />
							Message: '.$message.'<br />
							</p>
							
							<p>This was sent throught Contact Form @ Propagate World Wide Website
							
							<br /><br />
							With Regards<br />
							Propagate
							</p>';
		 
				//send_email($from,$from_text,$to,$subject,$message,'attachment','bcc'); 
				$this->Email_model->send_email($from,$from_text,$to,$subject,$email_message,'','');
				$this->session->set_flashdata('sent',true);
				$this->session->set_flashdata('contact_form_section','Touch Base');
			}else{
				$this->session->set_flashdata('error',true);
			}
		}
		redirect('contact');
	}
	
	
	
	function sendmsg_seo() 
	{
		$webaddress = $this->input->post('webaddress',true);
		$keyphrases = $this->input->post('keyphrases',true);
		$email = $this->input->post('email',true);
		$phone = $this->input->post('phone',true);
		$seo_contact_validator = $this->input->post('seo_contact_validator',true);
		$valid = true;
		
		
		if(!$seo_contact_validator){
			if(!$webaddress && !$keyphrases && !$email && !$phone){
				$valid = false;	
			}
		
			if($email){
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					$valid = false;	
				}
			}
	
			$from = $email;
			$from_text = 'SEO Report Request - Propagate';
			$subject = 'SEO Report Request';
			if($valid){
				
				$to = team_email;
				$email_message = '<p>A SEO report was request from Propagate report request page. The details are listed below.</p>
							
							<p>
							Web Address: '.$webaddress.'<br />
							Key Phrases: '.$keyphrases.'<br />
							Email: '.$email.'<br />
							Phone: '.$phone.'<br />
							</p>
							
							<p>This was sent throught SEO report request form @ Propagate World Wide Website
							<br /><br />
							With Regards<br />
							Propagate
							</p>';
		 
				//send_email($from,$from_text,$to,$subject,$message,'attachment','bcc'); 
				$this->Email_model->send_email($from,$from_text,$to,$subject,$email_message,'','');
				$this->session->set_flashdata('sent',true);
			}else{
				$this->session->set_flashdata('error',true);
			}
		}
		redirect('seo');
	}
	
	function sendmsg_tech_support() 
	{
		$name = $this->input->post('name',true);
		$email = $this->input->post('email',true);
		$domain_name = $this->input->post('domain_name',true);
		$issue = $this->input->post('issue',true);
		$tech_support_validator = $this->input->post('tech_support_validator',true);
		$valid = true;
		
		
		if($tech_support_validator == ''){
			if(!$name && !$email && !$domain_name && !$issue){
				$valid = false;	
			}
		
			if($email){
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					$valid = false;	
				}
			}
	
			$from = $email;
			$from_text = 'Technical Support - Propagate';
			if($valid){
				
				$to = team_email;
				$subject = 'Technical Support Request';
				$email_message = '<p>A technical support was requested from Propagate Technical Support page. The details are listed below.</p>
							
							<p>
							Name: '.$name.'<br />
							Email: '.$email.'<br />
							Domain Name: '.$domain_name.'<br />
							Issue: '.$issue.'<br />
							</p>
							
							<p>This was sent through the Technical Support Contact Form @ Propagate World Wide Website
							
							<br /><br />
							With Regards<br />
							Propagate
							</p>';
		 
				//send_email($from,$from_text,$to,$subject,$message,'attachment','bcc'); 
				$this->Email_model->send_email($from,$from_text,$to,$subject,$email_message,'','');
				$this->session->set_flashdata('sent',true);
				$this->session->set_flashdata('contact_form_section','Technical Support');
			}else{
				$this->session->set_flashdata('error',true);
			}
		}
		redirect('contact');
	}
	
	function sendmsg_project_support() 
	{
		$name = $this->input->post('name',true);
		$email = $this->input->post('email',true);
		$project_title = $this->input->post('project_title',true);
		$issue = $this->input->post('issue',true);
		$project_support_validator = $this->input->post('project_support_validator',true);
		$valid = true;
		
		
		if($project_support_validator == ''){
			if(!$name && !$email && !$domain_name && !$issue){
				$valid = false;	
			}
		
			if($email){
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					$valid = false;	
				}
			}
	
			$from = $email;
			$from_text = 'Propagate World Wide Contact Page';
			if($valid){
				
				$to = team_email;
				$subject = 'Project Support Request';
				$email_message = '<p>Website Contact Form</p>
							
							<p>
							Name: '.$name.'<br />
							Email: '.$email.'<br />
							Project Title: '.$project_title.'<br />
							Issue: '.$issue.'<br />
							</p>
							
							<p>This was sent throught Project Support Contact Form @ Propagate World Wide Website</p>';
		 
				//send_email($from,$from_text,$to,$subject,$message,'attachment','bcc'); 
				$this->Email_model->send_email($from,$from_text,$to,$subject,$email_message,'','');
				$this->session->set_flashdata('sent',true);
			}else{
				$this->session->set_flashdata('error',true);
			}
		}
		redirect('contact');
	}
	
	function _slider_example()
	{
		$this->load->view('common/header');
		$this->load->view('content/slider_example');
		$this->load->view('common/footer');
	}
	
	function ticket()
	{
		$data['userid']=0;
		$this->load->view('content/ticket',$data);
	}
	
	
	function validate_login()
	{
		 $username_client = $this->input->post('username');
		 $password_client = $this->input->post('password');
		 //echo $username_client.$password_client;
		 //error_reporting(E_ALL);
		 $data['userid']=0;
		 $url = "http://www.propagate.com.au/accountcenter/clients/includes/api.php"; # URL to WHMCS API file
		 $username = "raquel"; # Admin username goes here
		 $password = "RAQUELs49"; # Admin password goes here
		 
		 $postfields["username"] = $username;
		 $postfields["password"] = md5($password);
		 /*$postfields["action"] = "addinvoicepayment"; #action performed by the [[API:Functions]]
		 $postfields["invoiceid"] = "1";
		 $postfields["transid"] = "TEST";
		 $postfields["gateway"] = "mailin";*/
		 /*
		 $postfields["action"] = "openticket"; 
		 $postfields["clientid"] = "248";
		 $postfields["deptid"] = "1";
		 $postfields["subject"] = "API Ticket";
		 $postfields["message"] = "This is a sample ticket opened by the API";
		 $postfields["priority"] = "Low";
		 $postfields["customfields"] = base64_encode(serialize(array("8"=>"propagate.com.au")));
		 */
		 
		 $postfields["action"] = "validatelogin";
		 $postfields["email"] = $username_client;
		 $postfields["password2"] = $password_client;
		 
		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_POST, 1);
		 curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		 curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		 $data = curl_exec($ch);
		 curl_close($ch);
		 
		 $data = explode(";",$data);
		 //print_r($data);
		 foreach ($data AS $temp) {
		   //$temp = explode("=",$temp);
		   //$results[$temp[0]] = $temp[1];
		   
		   if(strpos($temp,'userid')!==false)
		   {
		
			   $temp = explode("userid=",$temp);
			   //echo $temp[1].'<br>';
			   $data['userid']=$temp[1];
		   }
		 }

		 $this->load->view('content/ticket',$data);
	}
	function add_ticket()
	{
		 $clientid = $this->input->post('clientid');
		 $deptid = $this->input->post('deptid');
		 $subject = $this->input->post('subject');
		 $message = $this->input->post('message');
		 $urgency = $this->input->post('urgency');
		 //echo $username_client.$password_client;
		 //error_reporting(E_ALL);
		 $data['userid']=0;
		 $url = "http://www.propagate.com.au/accountcenter/clients/includes/api.php"; # URL to WHMCS API file
		 $username = "raquel"; # Admin username goes here
		 $password = "RAQUELs49"; # Admin password goes here
		 
		 $postfields["username"] = $username;
		 $postfields["password"] = md5($password);
		 
		 $postfields["action"] = "openticket"; 
		 $postfields["clientid"] = $clientid;
		 $postfields["deptid"] = $deptid;
		 $postfields["subject"] = $subject;
		 $postfields["message"] = $message;
		 $postfields["priority"] = $urgency;
		 //$postfields["customfields"] = base64_encode(serialize(array("8"=>"propagate.com.au")));
		 
		 
		
		 
		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_POST, 1);
		 curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		 curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		 $data = curl_exec($ch);
		 curl_close($ch);
		 
		 $data = explode(";",$data);
		 print_r($data);
		 /*
		 foreach ($data AS $temp) {
		   //$temp = explode("=",$temp);
		   //$results[$temp[0]] = $temp[1];
		   
		   if(strpos($temp,'userid')!==false)
		   {
		
			   $temp = explode("userid=",$temp);
			   //echo $temp[1].'<br>';
			   $data['userid']=$temp[1];
		   }
		 }
		 */
		 //$this->load->view('content/ticket',$data);
	}
	
	/*
	Function to send support ticket
	
	1. Get email customer and check if the email is valid and available in clients database from WHMCS
	2. Get client ID from the email
	3. Send ticket use client ID
	
	*/
	function sendticket()
	{
		 
		 $this->session->set_flashdata('contact_form_section','Project Support');
		 $email = $this->input->post('email');
		 $name = $this->input->post('name');
		 $subject = $this->input->post('project_title');
		 $message = $this->input->post('issue');
		 
		 #connect to API WHMCS
		 #URL, Username and Password
	  	 $url = "http://www.propagate.com.au/accountcenter/clients/includes/api.php"; # URL to WHMCS API file
		 $username = "raquel"; # Admin username goes here
		 $password = "RAQUELs49"; # Admin password goes here
		 
		 $postfields["username"] = $username;
		 $postfields["password"] = md5($password);
		 
		 
		 #connect to API WHMCS to call function get client details
		 $postfields["action"] = "getclientsdetails";
		 $postfields["email"] = $email;
		 $postfields["stats"] = true;
		 $postfields["responsetype"] = "xml";
		 
		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_POST, 1);
		 curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		 curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		 $data = curl_exec($ch);
		 curl_close($ch);
		 
		 
		 $xml = new SimpleXMLElement($data);
		 $result = $xml->result[0];
		 
		 if($result=='success'){
		 	$clientid= $xml->client[0]->userid;
			
			#send ticket
			$deptid = 1; #for support department
			$postfields["action"] = "openticket"; 
			$postfields["clientid"] = $clientid;
			$postfields["deptid"] = $deptid;
			$postfields["subject"] = $subject;
			$postfields["message"] = $message;
			//$postfields["priority"] = $urgency;
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 100);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
			$data = curl_exec($ch);
			curl_close($ch);
			
			$xml_ticket = new SimpleXMLElement($data);
		 	$result_ticket = $xml_ticket->result[0];
		 
		 	if($result_ticket=='success'){
				$this->session->set_flashdata('send_ticket','success');
			}
			else
			{
				$this->session->set_flashdata('send_ticket','failed');
			}
			
		 }
		 else
		 {
		 	$this->session->set_flashdata('client_email','failed');
		 }
		 redirect('contact');
		 
	}
	
	/**
	*	@desc Shows the location details based on location permalink
	*	
	*	@name location
	*	@access public
	*	@param string[permalink]
	*	@return loads the location details page
	*	@comments This page doesn't quite follow the default bootstrap grid layout<br /> 
		and few custom css overwrites has been written to comply with the design template
	*	@update Changed color of the header text from blue to grey
	*	@updated-by Kaushtuv - 20 Jan, 2014
	*	@views common/header and footer, content/location
	*   @views/content/location This contains the location page where the user can edit various locations
	*/
	
	function location($permalink)
	{
		$header['meta_data'] = array(
								'title' => 'Web Application Development Process | Propagate Digital Agency Melbourne',
								'desc' => 'We deliver an amazing digital asset in the form of a custom built web site and online shopping experience.',
								'keywords' => 'propagate digital melbourne, digital company australia, web development company melbourne, web development process'
								);
		$this->load->view('common/header',$header);
		$this->load->view('content/location');
		$this->load->view('common/footer');
	}
	
	
}
?>