<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class myob {
    
    function myob()
    {
        $CI = & get_instance();
        log_message('Debug', 'MYOB class is loaded.');
    }
 
    function load()
    {
        include_once APPPATH.'/third_party/MYOB/myob_api_oauth.php';
        return new myob_api_oauth();
    }
}