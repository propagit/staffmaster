<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Induction extends MX_Controller {

    var $user = null;

    function __construct()
    {
        parent::__construct();
        $this->load->model('induction_model');

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

            # Get contents of the step
            $contents = $this->induction_model->get_contents($current_step['id']);
            $data['contents'] = $contents;

            if ($current_step['fields']) {
                $data['fields'] = json_decode(modules::run('induction/ajax/profile_fields', $current_step['id'], $current_step['type']));
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

        # Second get list of steps
        $steps = $this->induction_model->get_steps($id);

        # Determine step number based on uri
        if (!$step_number) { $step_number = 0; }

        if (isset($steps[$step_number])) {
            # Form validation libray
            $this->load->library('form_validation');

            # Get current step
            $current_step = $steps[$step_number];
            $data['current_step'] = $current_step;

            # Get contents of the step
            $contents = $this->induction_model->get_contents($current_step['id']);
            $data['contents'] = $contents;

            $validated = true;
            if ($current_step['fields']) {
                $fields = json_decode(modules::run('induction/ajax/profile_fields', $current_step['id'], $current_step['type']));
                $active_fields = array();
                $step_fields = json_decode($current_step['fields']);

                foreach($fields as $field) {
                    if (in_array($field->key, $step_fields)) {
                        $active_fields[] = $field;
                    }
                }
                $data['fields'] = $active_fields;

                foreach($active_fields as $field) {
                    if ($field->key == 'dob') {
                        $this->form_validation->set_rules($field->key . '[day]', 'Day', 'required');
                        $this->form_validation->set_rules($field->key . '[month]', 'Month', 'required');
                        $this->form_validation->set_rules($field->key . '[year]', 'Year', 'required');
                    } else {
                        $this->form_validation->set_rules($field->key, $field->label, 'required');
                    }
                }

                if ($this->form_validation->run() == FALSE) {
                    $validated = false;
                } else {

                }
            }

            if ($validated) {
                $status = $step_number + 1;
                $user_induction['status'] = $status;

                $this->induction_model->update_user($user_induction['id'], $user_induction);
                if ($status == count($steps)) {
                    redirect('');
                }
                redirect('induction/publish/' . $id . '/' . $status);
            }

        }

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

                }
            }


            # Now check if the induction has been finished yet

            $user_induction = $this->induction_model->check_user($induction['id'], $this->user['user_id']);
            $steps = $this->induction_model->get_steps($induction['id']);
            if ($user_induction['status'] < count($steps)) {
                return $induction['id'];
            }
        }
        return false;
    }
}
