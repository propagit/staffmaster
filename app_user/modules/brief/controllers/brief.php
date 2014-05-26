<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Brief extends MX_Controller {

	/**
	*	@class_desc Brief controller. 
	*	
	*
	*/
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('brief_model');
		$this->load->model('job/job_model');
		$this->load->model('job/job_shift_model');
	}
	
	function index($method='', $param='',$param2='')
	{
		
		switch($method)
		{
			case 'edit':
				$this->edit($param);
			break;
			case 'create_brief':
				$this->create_brief();
			break;
			//loads in briev viewer template
			case 'view_brief':
				$this->view_brief($param,$param2);
			break;
			case 'view':
				$this->view($param);
			break;
			case 'view_information_sheet':
				$this->view_information_sheet($param);
			break;
			case 'download':
					$this->download($param);
				break;
			default:
				$this->list_view($param);
			break;
		}
		
	}
	/**
	*	@name: list_view
	*	@desc: This is the default view for brief builder module. This loads the list of existing brief and allows user to search existing brief and add new brief.
	*	@access: public
	*	@param: (null)
	*	@return: Loads list of existing brief
	*/
	function list_view()
	{
		$this->load->view('brief_list_view', isset($data) ? $data : NULL);
	}
	/**
	*	@name: edit
	*	@desc: Provides UI to add elements to a brief such as documents and instructions.
	*	@access: public
	*	@param: ([int] brief id)
	*	@return: Loads UI which allows user to add new elements to a brief.
	*/
	function edit($brief_id)
	{
		$data['brief'] = $this->brief_model->get_brief($brief_id);
		$data['brief_id'] = $brief_id;
		$this->load->view('edit_brief', isset($data) ? $data : NULL);
	}
	/**
	*	@name: create_brief
	*	@desc: Creates new brief
	*	@access: public
	*	@param: ([via post] brief info such as brief name etc)
	*	@return: Redirects to edit page where user will be provided with tools to add elements to the brief.
	*/
	function create_brief()
	{
		$brief_name = $this->input->post('brief_name');
		$data_brief = array(
				'name' => $brief_name
				);
		$insert_id = $this->brief_model->add_brief($data_brief);
		//add encoded url to this brief
		$this->brief_model->update_brief($insert_id,array('encoded_url' => md5('brief_url'.$insert_id)));
		
		redirect('brief/edit/'.$insert_id);
	}
	
	/**
	*	@name: brief_select_field
	*	@desc: Create brief field select field
	*	@access: public
	*	@param: ([string] field name, [varchar] field value)
	*	@return: Loads brief in field select 
	*/
	function brief_select_field($field_name, $field_value=null)
	{
		$briefs = $this->brief_model->get_all_brief();
		$array = array();
		$array[] = array(
			'value' => 'information_sheet',
			'label' => 'Information Sheet'
			);
		foreach($briefs as $brief)
		{
			$array[] = array(
				'value' => $brief->brief_id,
				'label' => $brief->name
			);
		}
		return modules::run('common/field_select', $array, $field_name, $field_value);
	}
	
	/**
	*	@name: view_brief
	*	@desc: Shows brief view by shift id and brief id, the brief id can be null
	*	@access: public
	*	@param: ([int] shift id, [int] brief id)
	*	@return: Loads brief preview in the brief template
	*/
	function view_brief($shift_id,$brief_id = '')
	{
		$data['shift_info'] = $this->job_shift_model->get_shift_info($shift_id);
		$data['briefs'] = $this->job_shift_model->get_shift_brief_by_shift_id($shift_id);
		$data['brief_id'] = $brief_id;
		$data['referer'] = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : base_url());
		
		$this->load->view('brief_viewer/view_brief', isset($data) ? $data : NULL);	
	}
	
	/**
	*	@name: check_brief_status
	*	@desc: Check brief status - a brief is marked as active if any active shifts (shifts in the future) is using this brief
	*	@access: public
	*	@param: ([int] brief id)
	*	@return: [bool] true or false
	*/
	function check_brief_status($brief_id)
	{
		return $this->brief_model->check_brief_status($brief_id);
	}
	
	/**
	*	@name: view
	*	@desc: Loads brief preview by encoded url. Mostly used when a user see it via link sent thru emails
	*	@access: public
	*	@param: ([via post] brief info such as brief name etc)
	*	@return: Loads brief preview in brief template
	*/
	function view($encoded_url)
	{
		$brief = $this->brief_model->get_brief_by_encoded_url($encoded_url);
		if($brief){
			$data['brief'] = $brief;
			$data['brief_elements'] = $this->brief_model->get_brief_elements($brief->brief_id);	
			$this->load->view('public_view/view', isset($data) ? $data : NULL);	
		}else{
			redirect(base_url().'login');
		}
	}
	
	function view_information_sheet($shift_id = '')
	{
		$this->load->model('setting/setting_model');
		$shift_info =  $this->job_shift_model->get_shift_info_for_information_sheet($shift_id);
		$data['shift_info'] = $shift_info;
		$data['company_info'] = $this->setting_model->get_profile();
		$data['breaks'] = json_decode($shift_info->break_time);
		$data['payrate'] = modules::run('attribute/payrate/get_payrate',$shift_info->payrate_id);
		$data['shift_notes'] = $this->job_shift_model->get_job_shift_notes($shift_id);
		$data['user_data'] = modules::run('user/get_user',$shift_info->staff_id);
		$data['client'] = modules::run('client/get_client',$shift_info->client_id);
		$data['supervisor'] = array();
		if($shift_info->supervisor_id){
			$data['supervisor'] = modules::run('user/get_user',$shift_info->supervisor_id);
		}
		$data['other_working_staffs'] = $this->job_shift_model->get_other_working_staff($shift_info);
		$this->load->view('brief_viewer/view_information_sheet', isset($data) ? $data : NULL);	
	}	

	function download($shift_id,$redirect = true) {
		# As PDF creation takes a bit of memory, we're saving the created file in /uploads/pdf/
		$filename = "timesheet_" . $shift_id;
		if(!file_exists(UPLOADS_PATH.'/pdf/'.$filename.'.pdf')){
			$pdfFilePath = UPLOADS_PATH."/pdf/$filename.pdf";
			
			$dir = UPLOADS_PATH.'/pdf/';
			if(!is_dir($dir))
			{
			  mkdir($dir);
			  chmod($dir,0777);
			  $fp = fopen($dir.'/index.html', 'w');
			  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
			  fclose($fp);
			}
			 
			ini_set('memory_limit','128M'); # boost the memory limit if it's low 
			
			/*
			$invoice = $this->invoice_model->get_invoice($invoice_id);
			$data['invoice'] = $invoice;
			$data['client'] = modules::run('client/get_client', $invoice['client_id']);
			$data['items'] = $this->invoice_model->get_invoice_items($invoice_id);
			$data['company_profile'] = modules::run('setting/company_profile');
			$html = $this->load->view('create/download_view', isset($data) ? $data : NULL, true); 
			*/
			$shift = $this->job_shift_model->get_job_shift($shift_id);
			$job = $this->job_model->get_job($shift['job_id']);
			$venue = modules::run('attribute/venue/get_venue', $shift['venue_id']);
			$supervisor = modules::run('user/get_user', $shift['supervisor_id']);
			$data['job'] = $job;
			$data['shift'] = $shift;
			$data['venue'] = $venue;
			$data['supervisor'] = $supervisor;
			$html = $this->load->view('download_view', isset($data) ? $data : NULL, true);
			
					
			$this->load->library('pdf');
			$pdf = $this->pdf->load(); 			
			$stylesheet = file_get_contents('./assets/css/pdf.css');
			$custom_styles = '<style>'.modules::run('custom_styles').'</style>';
			//echo $custom_styles;exit();
			$pdf->WriteHTML($stylesheet,1);
			$pdf->WriteHTML($custom_styles,1);
			$pdf->WriteHTML($html,2);
			$pdf->Output($pdfFilePath, 'F'); // save to file 
		}
		
		if($redirect){ 
			redirect(UPLOADS_PATH."/pdf/$filename.pdf"); 
		}
	}

}