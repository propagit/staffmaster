<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('user/user_model');
        $this->load->model('staff/staff_model');
        $this->load->model('attribute/custom_field_model');
		$this->load->model('lookbook_model');
    }

    function profile_fields($category) {
        $fields = array();
        switch($category) {
            case 'personal':
                    $fields = array(
                        array('key' => 'title', 'label' => 'Title'),
                        array('key' => 'gender', 'label' => 'Gender'),
                        array('key' => 'first_name', 'label' => 'First Name'),
                        array('key' => 'last_name', 'label' => 'Last Name'),
                        array('key' => 'dob', 'label' => 'Date Of Birth'),
                        array('key' => 'address', 'label' => 'Address'),
                        array('key' => 'suburb', 'label' => 'Suburb'),
                        array('key' => 'postcode', 'label' => 'Postcode'),
                        array('key' => 'state', 'label' => 'State'),
                        array('key' => 'country', 'label' => 'Country'),
                        array('key' => 'phone', 'label' => 'Telephone'),
                        array('key' => 'mobile', 'label' => 'Mobile Phone')
                    );
					$configed_personal_fields = $this->lookbook_model->get_lookbook_config(LB_PERSONAL);
					if($configed_personal_fields){
						$cpf_temp_arr = json_decode($configed_personal_fields);
						foreach($fields as $key => $val){
							if(in_array($val['key'],$cpf_temp_arr)){
								array_push($fields,$fields[$key]['ticked'] = true);
							}
						}
					}
					
                break;
            case 'custom':
                    $custom_fields = $this->lookbook_model->get_fields();
                    foreach($custom_fields as $field) {
                        $field['key'] = $field['field_id'];
						if($field['type'] == 'fileDate'){
							$temp = json_decode($field['label']);
							$field['label'] = $temp->file_label; 
						}
                        $fields[] = $field;
                    }
					
					$configed_custom_fields = $this->lookbook_model->get_lookbook_config(LB_CUSTOM);
					if($configed_custom_fields){
						$ccf_temp_arr = json_decode($configed_custom_fields);
						foreach($fields as $key => $val){
							if(in_array($val['field_id'],$ccf_temp_arr)){
								array_push($fields,$fields[$key]['ticked'] = true);
							}
						}
					}
                break;
            default: $fields = array();
                break;
        }


        echo json_encode($fields);
    }
	
	function get_staff_card_config_view($staff_user_id)
	{
		echo modules::run('lookbook/get_staff_card_config_view',$staff_user_id);	
	}
	
	function update_lookbook_personal_config()
	{
		$input = file_get_contents("php://input");
		$configed_fields = $this->lookbook_model->get_lookbook_config(LB_PERSONAL);
		$config_arr = array();
		if($configed_fields){
			$config_arr = json_decode($configed_fields);
		}
		$new_config = array();
		
		$postdata = json_decode($input);
		if($postdata->ticked){
			# add new field	
			array_push($config_arr,$postdata->key);
			$new_config = $config_arr;
		}else{
			# remove existing field
			foreach($config_arr as $key => $val){
				if($val == $postdata->key){
					unset($config_arr[$key]);
				}
			}
			# re index array otherwise it will give an object when json encoded 
			$new_config = array_values($config_arr);
		}
		$this->lookbook_model->update_lookbook_config('personal',json_encode($new_config));
		
	}
	
	function update_lookbook_custom_config()
	{
		$input = file_get_contents("php://input");
		$configed_fields = $this->lookbook_model->get_lookbook_config(LB_CUSTOM);
		$config_arr = array();
		if($configed_fields){
			$config_arr = json_decode($configed_fields);
		}
		$new_config = array();
		
		$postdata = json_decode($input);
		if($postdata->ticked){
			# add new field	
			array_push($config_arr,$postdata->field_id);
			$new_config = $config_arr;
		}else{
			# remove existing field
			foreach($config_arr as $key => $val){
				if($val == $postdata->field_id){
					unset($config_arr[$key]);
				}
			}
			# re index array otherwise it will give an object when json encoded 
			$new_config = array_values($config_arr);
		}
		$this->lookbook_model->update_lookbook_config('custom',json_encode($new_config));	
	}
	
	function get_client_email($client_user_id)
	{
		$user = modules::run('user/get_user',$client_user_id);
		if($user){
			echo $user['email_address'];	
		}
	}
	
	function get_lookbook_config_data()
	{
		$input = $this->input->post();
		$selected_users = $input['user_staff_selected_user_id'];
		if($selected_users){
			$data['selected_user_ids'] = $selected_users;
			$data['preview_user_id'] = $selected_users[0];
			$data['total_selected_user'] = count($selected_users);
			$data['preview_url'] = base_url() . 'plb/preview/' . implode('-',$selected_users);
		}	
		echo json_encode($data);
	}
	
	function send_lookbook()
	{
		$input = $this->input->post();
		if(!$input['loobook_client_id']){
			echo json_encode(
							array(
									'ok' => false,
									'msg' => 'Please select a client'
								)
							);
			return;	
		}
		
		if(!$input['lookbook_email_to']){
			echo json_encode(
							array(
									'ok' => false,
									'msg' => 'Please enter an email address'
								)
							);
			return;	
		}
		
		if($input['lookbook_email_to']){
			if (!filter_var($input['lookbook_email_to'], FILTER_VALIDATE_EMAIL)) {
				echo json_encode(
							array(
									'ok' => false,
									'msg' => 'Invalid email address'
								)
							);
				return;	
			}
		}
		
		$config_personal = $this->lookbook_model->get_lookbook_config(LB_PERSONAL);
		$config_custom = $this->lookbook_model->get_lookbook_config(LB_CUSTOM);
		
		# update lookbook config message 
		$this->lookbook_model->update_lookbook_config('message',$input['lb_email_body']);
		
		$time = time();
		$key = md5($time.$input['lookbook_email_to']);
		
		$selected_users = explode(',',$input['selected_user_ids']);
		
		
		$data = array(
						'key' => $key,
						'included_user_ids' => json_encode($selected_users),
						'receiver_user_id' => $input['loobook_client_id'],
						'receiver_email' => $input['lookbook_email_to'],
						'personal_fields' => $config_personal,
						'custom_fields' => $config_custom
					);
		
		$lookbook_id = $this->lookbook_model->insert_lookbook($data);
		if($lookbook_id){
			$this->send_email($lookbook_id);
			echo json_encode(
							array(
									'ok' => true,
									'msg' => ''
								)
							);
		}
		
	}
	
	function send_email($lookbook_id)
	{
		$this->load->model('setting/setting_model');
		$lookbook = $this->lookbook_model->get_lookbook_by_id($lookbook_id);
		
		# get company profile
		$company = $this->setting_model->get_profile();	
	
		
		$data['email_body'] = $this->lookbook_model->get_lookbook_config(LB_MESSAGE);
		$company_email = $company['email'] ? $company['email'] : $company['email_c_email'];
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
		$data['url'] = base_url() .'plb/staffbook/' . $lookbook['key'];
		$lookbook_email = $this->load->view('email/email_template', isset($data) ? $data : NULL, true);


		$email_signature = modules::run('setting/get_email_footer');
		$message = $lookbook_email . $email_signature;
	
		
		$email_data = array(
								'to' => $lookbook['receiver_email'],
								'from' => $company_email ? $company_email : 'noreply@staffbook.com',
								'from_text' => 'StaffBook',
								'subject' => $company['company_name'] . ' - StaffBooks',
								'message' => $message,
								'overwrite' => true
							);
		
	
		modules::run('email/send_email',$email_data);		
	}
	
	
	
}
