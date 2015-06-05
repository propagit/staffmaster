<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('induction_model');
        $this->load->model('user/user_model');
        $this->load->model('staff/staff_model');
        $this->load->model('attribute/custom_field_model');
    }

    function get($id) {
        $induction = $this->induction_model->get($id);
        if ($induction['work_from']) {
            $induction['work_from'] = date('d-m-Y', strtotime($induction['work_from']));
        }
        if ($induction['work_to']) {
            $induction['work_to'] = date('d-m-Y', strtotime($induction['work_to']));
        }


        # State filter
        $induction_states = ($induction['state']) ? json_decode($induction['state']) : array();
        $states = array();
        foreach(modules::run('common/get_states') as $state) {
            if (in_array($state['code'], $induction_states)) {
                $state['ticked'] = true;
            }
            $states[] = $state;
        }

        # Group filter
        $induction_groups = ($induction['group']) ? json_decode($induction['group']) : array();
        $groups = array();
        foreach(modules::run('attribute/group/get_groups') as $group) {
            if (in_array($group['group_id'], $induction_groups)) {
                $group['ticked'] = true;
            }
            $groups[] = $group;
        }

        # Role filter
        $induction_roles = ($induction['role']) ? json_decode($induction['role']) : array();
        $roles = array();
        foreach(modules::run('attribute/role/get_roles') as $role) {
            if (in_array($role['role_id'], $induction_roles)) {
                $role['ticked'] = true;
            }
            $roles[] = $role;
        }

        # Age filter
        $ages_values = array(
            array('value' => '0-17', 'name' => 'Under 18 Years Old'),
            array('value' => '18-25', 'name' => '18 -25 Years Old'),
            array('value' => '26-35', 'name' => '26 - 35 Years Old'),
            array('value' => '36-100', 'name' => '35+ Years Old')
        );
        $induction_ages = ($induction['age']) ? json_decode($induction['age']) : array();
        $ages = array();
        foreach($ages_values as $age) {
            if (in_array($age['value'], $induction_ages)) {
                $age['ticked'] = true;
            }
            $ages[] = $age;
        }

        echo json_encode(array(
            'induction' => $induction,
            'states' => $states,
            'groups' => $groups,
            'roles' => $roles,
            'ages' => $ages
        ));
    }

    function add() {
        $input = $this->input->post();
        if (!$input['name']) {
            echo json_encode(array('ok' => false));
            return;
        }
        $id = $this->induction_model->add($input);
        echo json_encode(array('ok' => true, 'id' => $id));
    }

    function update($id) {
        $input = file_get_contents("php://input");
        $input = json_decode($input,true);
        if (!isset($input['status'])) { $input['status'] = 0; }
        foreach($input as $key => $value) {
            if (is_array($value)) {
                $input[$key] = json_encode($value);
            }
            if ($key == 'work_from' || $key == 'work_to') {
                $values = explode('-', $value);
                $input[$key] = NULL;
                if (count($values) == 3) {
                    $input[$key] = $values[2] . '-' . $values[1] . '-' . $values[0];
                }
            }
        }
        $this->induction_model->update($id, $input);
    }

    function delete($id) {
        $this->induction_model->delete($id);
    }

    function add_step() {
        $input = file_get_contents("php://input");
        $input = json_decode($input,true);
        if (!isset($input['induction_id']) || !isset($input['type'])) {
            return;
        }
        $step = $this->induction_model->add_step($input);
        echo json_encode($step);
    }

    function update_step($id) {
        $input = file_get_contents("php://input");
        $input = json_decode($input,true);
        if ($input['fields']) {
            $input['fields'] = json_encode($input['fields']);
        }
        $this->induction_model->update_step($id, $input);
        echo json_encode($input);
    }

    function get_steps($induction_id)
    {
        $steps = $this->induction_model->get_steps($induction_id);
        echo json_encode($steps);
    }

    function delete_step($id)
    {
        $this->induction_model->delete_step($id);
    }

    function add_content() {
        $input = file_get_contents("php://input");
        $input = json_decode($input,true);
        if (!isset($input['induction_id'])
            || !isset($input['step_id'])
            || !isset($input['type'])) {
            return;
        }
        $content = $this->induction_model->add_content($input);
        echo json_encode($content);
    }

    function get_contents($step_id) {
        $contents = $this->induction_model->get_contents($step_id);
        echo json_encode($contents);
    }

    function update_content($id) {
        $input = file_get_contents("php://input");
        $input = json_decode($input,true);
        $this->induction_model->update_content($id, $input);
        echo json_encode($input);
    }

    function delete_content($id) {
        $this->induction_model->delete_content($id);
    }

    function upload_image($id) {
        $config['upload_path'] = UPLOADS_PATH . '/tmp/';
		# Create target dir
        if (!file_exists($config['upload_path'])) {
            @mkdir($config['upload_path']);
        }
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2000';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('image'))
        {
            echo json_encode($this->upload->display_errors());
        }
        else
        {
            echo json_encode($this->upload->data());
        }
    }

    function upload_file($id) {
        $config['upload_path'] = UPLOADS_PATH . '/tmp/';
		# Create target dir
        if (!file_exists($config['upload_path'])) {
            @mkdir($config['upload_path']);
        }
        $config['allowed_types'] = 'pdf|csv|doc|ppt|docx|zip|mp3|mov|xl|xls|avi';
        $config['max_size'] = '10000';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('file'))
        {
            echo json_encode($this->upload->display_errors());
        }
        else
        {
            echo json_encode($this->upload->data());
        }
    }

    function upload_staff_picture($user_id) {
        $targetDir = UPLOADS_PATH . '/staff/' . $user_id;
        // Create target dir
        if (!file_exists($targetDir)) {
            modules::run('staff/create_staff_dir',$user_id);
        }
        $dir_thumb = $targetDir . '/thumb';

        $config['upload_path'] = UPLOADS_PATH . '/staff/' . $user_id;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '2048';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('image'))
        {
			$err_postfix = '<br>Permitted file types [gif, jpg, jpeg, png] 
							<br>Max Size [2 MB] 
							<br>Dimension [W 1024 px - H 768 px]';
			$staff_pic_upload_error = $this->upload->display_errors();
			$this->session->set_flashdata('staff_pic_upload_error',$staff_pic_upload_error . $err_postfix);
            echo json_encode($staff_pic_upload_error);
        }
        else
        {
            $data = $this->upload->data();
            $photo = array(
                'user_id' => $user_id,
                'name' => $data['file_name'],
                'hero' => ($this->staff_model->has_hero_image($user_id) ? 0 : 1)
            );

            $a = $this->staff_model->add_picture($photo);

            $target = $dir_thumb . '/' . $data['file_name'];

            copy($targetDir . '/' . $data['file_name'], $target);
            $this->load->helper('image');
            scale_image($target, $target, IMG_THUMB_SIZE, IMG_THUMB_SIZE);

            echo json_encode($data);

        }
    }

    function delete_picture($id) {
        $this->staff_model->delete_photo($id);
    }

    function upload_custom_file($user_id, $field_id) {
		if (!file_exists($targetDir)) {
            modules::run('staff/create_staff_dir',$user_id);
        }
        $config['upload_path'] = UPLOADS_PATH . '/staff/' . $user_id;
        $config['allowed_types'] = 'pdf|csv|doc|ppt|docx|zip|mp3|mov|xl|xls|avi|jpg|gif|png|jpeg';
        $config['max_size'] = '2048';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('file-' . $field_id))
        {
            #echo json_encode($this->upload->display_errors());
			$err_postfix = '<br>Permitted file types [pdf, csv, doc, ppt, docx, zip, mp3, mov, xl, xls, avi, jpg, jpeg, gif, png] 
						    <br>Max Size [2 MB]';
			$custom_file_upload_error = $this->upload->display_errors();
			$this->session->set_flashdata('custom_file_upload_error_' . $field_id,$custom_file_upload_error . $err_postfix);
            echo json_encode($custom_file_upload_error);
        }
        else
        {
            $data = $this->upload->data();
            $this->staff_model->update_custom_field($user_id, $field_id, $data['file_name'],true);

            echo json_encode($data);
        }
    }

    function delete_file($user_id, $field_id) {
        $this->staff_model->update_custom_field($user_id, $field_id, '');
    }

    function profile_fields($step_id = '', $category = '', $preview = false) {
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
                        array('key' => 'mobile', 'label' => 'Mobile Phone'),
                        array('key' => 'emergency_contact', 'label' => 'Emergency Contact'),
                        array('key' => 'emergency_phone', 'label' => 'Emergency Phone')
                    );
                break;
            case 'financial':
                    $fields = array(
                        array('key' => 'f_acc_name', 'label' => 'Account Name'),
                        array('key' => 'f_acc_number', 'label' => 'Account Number'),
                        array('key' => 'f_bsb', 'label' => 'BSB')
                    );
                break;
            case 'super':
                    $fields = array(
                        array('key' => 's_fund_name', 'label' => 'Super Fund Name'),
                        array('key' => 's_membership', 'label' => 'Membership Number')
                    );
                break;
            case 'custom':
                    $custom_fields = $this->custom_field_model->get_fields();
                    foreach($custom_fields as $field) {
                        $field['key'] = $field['field_id'];
						if($field['type'] == 'fileDate'){
							$temp = json_decode($field['label']);
							$field['label'] = $temp->file_label; 
						}
                        $fields[] = $field;
                    }
                break;
            default: $fields = array();
                break;
        }


        $step = $this->induction_model->get_step($step_id);
        if ($step && $step['fields']) {
            $result = array();
            $step_fields = json_decode($step['fields']);
            foreach($fields as $field) {
				if($preview){
					$f = $field;
					if (in_array($field['key'], $step_fields)) {
						$f['ticked'] = true;
						$result[] = $f;
					}
				}else{
					$f = $field;
					if (in_array($field['key'], $step_fields)) {
						$f['ticked'] = true;
					}
					
					$result[] = $f;
				}
            }
            $fields = $result;
        }
        echo json_encode($fields);
    }
}
