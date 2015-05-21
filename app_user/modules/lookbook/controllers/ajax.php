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
                break;
            case 'custom':
                    $custom_fields = $this->custom_field_model->get_fields();
                    foreach($custom_fields as $field) {
                        $field['key'] = $field['field_id'];
                        $fields[] = $field;
                    }
                break;
            default: $fields = array();
                break;
        }


        
        echo json_encode($fields);
    }
}
