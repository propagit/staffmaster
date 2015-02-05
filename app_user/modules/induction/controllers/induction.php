<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Induction extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('induction_model');
    }

    function index($method='', $param='')
    {
        switch($method)
        {
            case 'build': $this->build_view($param);
                break;
            case 'setting': $this->setting_view($param);
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
}
