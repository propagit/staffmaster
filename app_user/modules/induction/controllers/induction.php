<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Induction extends MX_Controller {

    var $user = null;

    function __construct()
    {
        parent::__construct();
        $this->load->model('induction_model');
        $this->load->model('user/user_model');
        $this->load->model('staff/staff_model');

        $this->user = $this->session->userdata('user_data');
    }

    function index($method='', $param='', $param2='')
    {
        switch($method)
        {
            case 'build': $this->build_view($param);
                break;
            case 'setting': $this->setting_view($param);
                break;
            case 'preview': $this->preview_view($param, $param2);
                break;
            case 'publish': $this->publish_view($param, $param2);
                break;
            default: $this->main_view();
                break;
        }
    }

    function main_view()
    {
        $data['inductions'] = $this->induction_model->all();
        $this->load->view('main_view', isset($data) ? $data : NULL);
    }

    function build_view($id)
    {
        $data['induction'] = $this->induction_model->get($id);
        $this->load->view('build_view', isset($data) ? $data : NULL);
    }

    function setting_view($id)
    {
        $data['induction'] = $this->induction_model->get($id);
        $this->load->view('setting_view', isset($data) ? $data : NULL);
    }

    function preview_view($id, $step_number)
    {
        # First get the induction itself
        $data['induction'] = $this->induction_model->get($id);


        # Second get list of steps
        $steps = $this->induction_model->get_steps($id);

        # Determine step number based on uri
        if (!$step_number) { $step_number = 0; }

        if (isset($steps[$step_number])) {

            # Get current step
            $current_step = $steps[$step_number];
            $data['current_step'] = $current_step;

            if ($current_step['type'] == 'role') {
                $data['roles'] = modules::run('attribute/role/get_roles');
            } else if ($current_step['type'] == 'group') {
                $data['groups'] = modules::run('attribute/group/get_groups');
            } else if ($current_step['type'] == 'availability') {
                $data['days'] = modules::run('common/array_day');
            }

            # Get contents of the step
            $contents = $this->induction_model->get_contents($current_step['id']);
            $data['contents'] = $contents;

            if ($current_step['fields']) {
                $fields = json_decode(modules::run('induction/ajax/profile_fields', $current_step['id'], $current_step['type'], true));
                $data['fields'] = $fields;
					
            }

        }

        $data['steps'] = $steps;
        $data['step_number'] = $step_number;
        $this->load->view('preview_view', isset($data) ? $data : NULL);
    }

    function publish_view($id, $step_number)
    {
        # First get the induction itself
        $data['induction'] = $this->induction_model->get($id);

        # Get the user induction status
        $user_induction = $this->induction_model->get_user($id, $this->user['user_id']);
        if (!$user_induction) {
            show_404();
        }
        if ($step_number > $user_induction['status'])
        {
            redirect('induction/publish/' . $id . '/' . $user_induction['status']);
        }
        $data['user_induction'] = $user_induction;
        $user_contents = array();
        if ($user_induction['contents']) {
            $user_contents = json_decode($user_induction['contents']);
        }
        $data['user_contents'] = $user_contents;

        # Second get list of steps
        $steps = $this->induction_model->get_steps($id);

        # Determine step number based on uri
        if (!$step_number) { $step_number = 0; }

        if (isset($steps[$step_number])) {
            # Form validation libray
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_id', 'ID', 'required');

            # Get current step
            $current_step = $steps[$step_number];
            $data['current_step'] = $current_step;
            $data['staff'] = modules::run('staff/get_staff', $this->user['user_id']);
            if ($current_step['type'] == 'financial') {

                $this->form_validation->set_rules('f_acc_name', 'Account Name', 'required');
                $this->form_validation->set_rules('f_bsb', 'BSB', 'required');
                $this->form_validation->set_rules('f_acc_number', 'Account Number', 'required');
                $this->form_validation->set_rules('f_employed', 'Employed As', 'required');
                if ($this->input->post('f_employed') == 1) {
                    $this->form_validation->set_rules('f_tfn', 'TFN Number', 'required');

                } else if ($this->input->post('f_employed') == 2) {
                    $this->form_validation->set_rules('f_abn', 'ABN Number', 'required');
                }

            } else if ($current_step['type'] == 'super') {

                $this->form_validation->set_rules('s_external_id', 'Super Fund', 'required');
                $this->form_validation->set_rules('s_employee_id', 'Membership Number', 'required');

            } else if ($current_step['type'] == 'picture') {
                $pictures = $this->staff_model->get_all_photos($user_induction['user_id']);
                if (count($pictures) == 0) {
                    $this->form_validation->set_rules('pictures', 'Picture', 'required');
                }
                $data['pictures'] = $pictures;
            } else if ($current_step['type'] == 'role') {
                $data['roles'] = modules::run('attribute/role/get_roles');
                $this->form_validation->set_rules('roles', 'Role', 'required');
            } else if ($current_step['type'] == 'group') {
                $data['groups'] = modules::run('attribute/group/get_groups');
                $this->form_validation->set_rules('groups', 'Group', 'required');
            } else if ($current_step['type'] == 'availability') {
                $data['days'] = modules::run('common/array_day');
                $data['staff_days'] = $this->staff_model->get_available_days($this->user['user_id']);
                $this->form_validation->set_rules('days', 'Day', 'required');
            } else if ($current_step['type'] == 'location') {
                $user_data = modules::run('staff/get_staff', $this->user['user_id']);
				$location = array();
				if($user_data['locations']){
					$a = json_decode($user_data['locations']);
					foreach($a as $key => $value) {
						$location = $key; break;
					}
				}
                $data['location'] = $location;
                $this->form_validation->set_rules('location', 'Location', 'required');
            }

            # Get contents of the step
            $contents = $this->induction_model->get_contents($current_step['id']);
            if (count($contents) > 0) {
                foreach($contents as $content) {
                    if ($content['type'] == 'compliance') {
                        $this->form_validation->set_rules('contents[' . $content['id'] . ']', 'Compliance', 'required');
                    }
                }
            }

            $data['contents'] = $contents;

            if ($current_step['fields']) {
                $fields = json_decode(modules::run('induction/ajax/profile_fields', $current_step['id'], $current_step['type']));
                $active_fields = array();
                $step_fields = json_decode($current_step['fields']);

                $user_data = array();
                if (in_array($current_step['type'], array('personal','financial','super')))
                {
                    $user_data = modules::run('staff/get_staff', $this->user['user_id']);
                }

                foreach($fields as $field) {
                    if (in_array($field->key, $step_fields)) {
                        $field->value = '';
                        if (isset($user_data[$field->key])) {
                            $field->value = $user_data[$field->key];
                        }
                        else {
                            $custom_field = $this->staff_model->get_custom_field($this->user['user_id'], $field->key);
                            if ($custom_field) {
                                $field->value = $custom_field['staff_value'];
                            }
                        }
                        $active_fields[] = $field;
                    }
                }
                $data['fields'] = $active_fields;

                foreach($active_fields as $field) {
                    if ($field->key == 'dob') {
                        $this->form_validation->set_rules($field->key . '[day]', 'Day', 'required');
                        $this->form_validation->set_rules($field->key . '[month]', 'Month', 'required');
                        $this->form_validation->set_rules($field->key . '[year]', 'Year', 'required');
                    } else if (isset($field->type) && $field->type == 'file') {

                    } else {
                        $this->form_validation->set_rules($field->key, $field->label, 'required');
                    }
                }
            }

            if ($this->form_validation->run() == FALSE) {

            } else {
                $status = $step_number + 1;
                if ($status > $user_induction['status']) {
                    $user_induction['status'] = $status;
                }

                $continue = $this->input->post('continue');

                # Update
                if (in_array($current_step['type'], array('personal', 'financial', 'super')))
                {
                    modules::run('staff/update_staff', $this->user['user_id'], $this->input->post());
                }
                else if($current_step['type'] == 'role') {
                    $roles = $this->input->post('roles');
                    $this->staff_model->delete_staff_roles($this->user['user_id']);
                    foreach($roles as $role_id) {
                        $this->staff_model->add_staff_role($this->user['user_id'],$role_id);
                    }
                }
                else if($current_step['type'] == 'group') {
                    $groups = $this->input->post('groups');
                    $this->staff_model->delete_staff_groups($this->user['user_id']);
                    foreach($groups as $group_id) {
                        $this->staff_model->add_staff_group($this->user['user_id'], $group_id);
                    }

                }
                else if($current_step['type'] == 'availability') {
                    $this->staff_model->delete_availability_data($this->user['user_id']);
                    $days = $this->input->post('days');
                    $values = '';
                    for($day=1; $day <=7; $day++) {
                        for($hour=0; $hour <=23; $hour++) {
                            $ok = in_array($day, $days) ? '1' : '0';
                            $values .= '('.$this->user['user_id'].','.$day.','.$hour.','.$ok.'),';
                        }
                    }
                    $values = rtrim($values,',');
                    $sql = "INSERT INTO `user_staff_availability` (`user_id`, `day`, `hour`, `value`) VALUES ".$values;
                    $this->db->query($sql);
                }
                else if($current_step['type'] == 'location') {
                    $parent_id = $this->input->post('location');
                    /*$locations = array();
                    $location = array();
                    $all = modules::run('attribute/location/get_locations', $parent_id);
                    foreach($all as $a) {
                        $location[] = $a['location_id'];
                    }
                    $locations[$parent_id] = $location;
					modules::run('staff/update_staff', $this->user['user_id'], array(
                        'locations' => json_encode($locations)
                    ));*/
					modules::run('staff/add_locations', $this->user['user_id'],$parent_id);
                }
                else if ($current_step['type'] == 'custom') {
                    $input = $this->input->post();
                    unset($input['user_id']);
                    unset($input['continue']);
                    foreach($input as $field_id => $value) {
                        if (is_array($value)) {
                            $value = json_encode($value);
                        }
                        $this->staff_model->update_custom_field($this->user['user_id'], $field_id, $value);
                    }
                }
                else if($current_step['type'] == 'content')
                {
                    $input = $this->input->post();
                    if (isset($input['contents'])) {
                        $input_contents = $input['contents'];
                        foreach($input_contents as $input_content) {
                            if (!in_array($input_content, $user_contents)) {
                                $user_contents[] = $input_content;
                            }
                        }
                        $user_induction['contents'] = json_encode($user_contents);
                    }
                }

                if ($continue == 1) {
                    if ($status == count($steps)) {
                        $user_induction['finished_on'] = date('Y-m-d H:i:s');
                        $this->induction_model->update_user($user_induction['id'], $user_induction);
                        redirect('');
                    }

                    $this->induction_model->update_user($user_induction['id'], $user_induction);
                    redirect('induction/publish/' . $id . '/' . $status);
                }

            }

        }
		
		$post = $this->input->post();
		$data['posted_data'] = $post ? $post : NULL; 
        $data['steps'] = $steps;
        $data['step_number'] = $step_number;
        $this->load->view('publish_view', isset($data) ? $data : NULL);
    }

    function check_staff_induction()
    {
        # Check if any induction is active and meet staff parameter
        $inductions = $this->induction_model->all(true);

        foreach($inductions as $induction)
        {
            # If not target the existing staff
            if (!$induction['target_all'] && $this->user['created_on'] < $induction['created_on'])
            {
                # Skip this induction
                continue;
            }
            else
            {
                if ($induction['state'])
                {
                    $states = json_decode($induction['state']);
                    if (!in_array($this->user['state'], $states))
                    {
                        continue;
                    }
                }
                if ($induction['group'])
                {
                    $groups = json_decode($induction['group']);
                    $matched = false;
                    foreach($groups as $group_id) {
                        if (modules::run('staff/check_staff_has_group', $this->user['user_id'], $group_id)) {
                            $matched = true;
                        }
                    }
                    if (!$matched) { continue; }
                }
                if ($induction['role'])
                {
                    $roles = json_decode($induction['role']);
                    $matched = false;
                    foreach($roles as $role_id) {
                        if (modules::run('staff/check_staff_has_role', $this->user['user_id'], $role_id)) {
                            $matched = true;
                        }
                    }
                    if (!$matched) { continue; }
                }
                if ($induction['age'])
                {
                    $ages = json_decode($induction['age']);
                    $staff_age = modules::run('staff/get_age', $this->user['user_id']);
                    $matched = false;
                    foreach($ages as $age) {
                        $seg = explode('-', $age);
                        if ($seg[0] <= $staff_age & $staff_age <= $seg[1]) {
                            $matched = true;
                        }
                    }
                    if (!$matched) { continue; }
                }
                if ($induction['gender']) {
                    $staff = modules::run('staff/get_staff', $this->user['user_id']);
                    if ($staff['gender'] != $induction['gender']) {
                        continue;
                    }

                }
                if ($induction['work_from']) {
                    if (!$this->staff_model->check_staff_work_from($this->user['user_id'], $induction['work_from'])) {
                        continue;
                    }
                }
                if ($induction['work_to']) {
                    if (!$this->staff_model->check_staff_work_to($this->user['user_id'], $induction['work_to'])) {
                        continue;
                    }
                }
            }


            # Now check if the induction has been finished yet

            $user_induction = $this->induction_model->check_user($induction['id'], $this->user['user_id']);
            $steps = $this->induction_model->get_steps($induction['id']);
            if ($user_induction['status'] < count($steps)) {
                return $induction['id'] . '/' . $user_induction['status'];
            }
        }
        return false;
    }
}
