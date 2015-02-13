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

    function check_staff_induction()
    {
        # First check if the staff has unfinished induction

        # Then check if any induction is active and meet staff parameter
        $inductions = $this->induction_model->all(true);

        foreach($inductions as $induction)
        {
            # If not target the existing staff
            if (!$induction['target_all'] && $this->user['created_on'] < $induction['created_on'])
            {
                continue;
            }
            return 'test';
        }
    }
}
