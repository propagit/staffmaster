<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class cbf {
    
    function cbf()
    {
        $CI = & get_instance();
        log_message('Debug', 'Cbf class is loaded.');
    }
 
    function load()
    {
        include_once APPPATH.'/third_party/cbf/SendSMS.php';
        return new SendSMS();
    }
}