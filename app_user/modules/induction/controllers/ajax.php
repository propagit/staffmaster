<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('induction_model');
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

    function add_step() {
        $input = $this->input->post();
        if (!$input['induction_id'] || !$input['type']) {
            return;
        }
        $id = $this->induction_model->add_step($input);
        echo json_encode(array('ok' => true));
    }

    function get_steps($induction_id)
    {
        $steps = $this->induction_model->get_steps($induction_id);
        $number = 1;
        foreach($steps as $step) {
            $this->load->view('step/' . $step['type'], array(
                'step' => $step,
                'number' => $number++
            ));
        }
    }

    function delete_step($id)
    {
        $this->induction_model->delete_step($id);
    }



}
