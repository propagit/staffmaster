<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$handle = opendir(APPPATH.'modules');
if ($handle)
{
	while ( false !== ($module = readdir($handle)) )
	{
		# make sure we don't map silly dirs like .svn, or . or ..
		
		if (substr($module, 0, 1) != ".")
		{
			if ( file_exists(APPPATH.'modules/'.$module.'/config/routes.php') )
			{
				include(APPPATH.'modules/'.$module.'/config/routes.php');
			}		
		}
	}
}

$route['default_controller'] = "dispatcher";

$route['login'] = 'auth/login_user';
$route['logout'] = 'auth/logout_user';



$modules = array('job', 'staff', 'client', 'roster', 'work', 'timesheet', 'invoice', 'payrun', 'expense', 'setting', 'export', 'email', 'report', 'forum', 'log','account','support');
$path = implode('|', $modules);
$route['(' . $path . ')'] = 'dispatcher/user_dispatcher/$1';
$route['(' . $path . ')/(:any)'] = 'dispatcher/user_dispatcher/$1/$2';
$route['(' . $path . ')/(:any)/(:any)'] = 'dispatcher/user_dispatcher/$1/$2/$3';
$route['(' . $path . ')/(:any)/(:any)/(:any)'] = 'dispatcher/user_dispatcher/$1/$2/$3/$4';
$route['(' . $path . ')/(:any)/(:any)/(:any)/(:any)'] = 'dispatcher/user_dispatcher/$1/$2/$3/$4/$5';
$route['(' . $path . ')/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'dispatcher/user_dispatcher/$1/$2/$3/$4/$5/$6';


#$route['client/(:any)'] = 'dispatcher/user_dispatcher/client/$1';
#$route['(job|staff|roster|work)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'dispatcher/user_dispatcher/$1/$2/$3/$4/$5/$6';
#$route['(job|staff|roster|work|timesheet|invoice|payrun|setting|export|email)'] = 'dispatcher/user_dispatcher/$1';
#$route['(job|staff|roster|work|timesheet|invoice|payrun|setting|export|email)/(:any)'] = 'dispatcher/user_dispatcher/$1/$2';
#$route['(job|staff|roster|work|timesheet|invoice|payrun|setting|export|email)/(:any)/(:any)'] = 'dispatcher/user_dispatcher/$1/$2/$3';
#$route['(job|staff|roster|work|timesheet|invoice|payrun|setting|export|email)/(:any)/(:any)/(:any)'] = 'dispatcher/user_dispatcher/$1/$2/$3/$4';
#$route['(job|staff|roster|work|timesheet|invoice|payrun|setting|export|email)/(:any)/(:any)/(:any)/(:any)'] = 'dispatcher/user_dispatcher/$1/$2/$3/$4/$5';


$route['attribute/(:any)'] = 'dispatcher/user_dispatcher/attribute/$1';
$route['attribute/(:any)/(:any)'] = 'dispatcher/user_dispatcher/attribute/$1/$2';
$route['attribute/(:any)/(:any)/(:any)'] = 'dispatcher/user_dispatcher/attribute/$1/$2/$3';


$route['admin'] = 'dispatcher/admin_dispatcher';

$route['admin/login'] = 'auth/login_admin';
$route['admin/logout'] = 'auth/logout_admin';

$route['admin/(:any)'] = 'dispatcher/admin_dispatcher/$1';


//form builder
$route['formbuilder'] = 'dispatcher/user_dispatcher/formbuilder';
//documentor

$route['documentor'] = 'document_dispacher';
$route['documentor/(:any)'] = 'document_dispacher/index/documentor/$1';
$route['documentor/(:any)/(:any)'] = 'document_dispacher/index/documentor/$1/$2';
$route['documentor/(:any)/(:any)/(:any)'] = 'document_dispacher/index/documentor/$1/$2/$3';
$route['documentor/(:any)/(:any)/(:any)/(:any)'] = 'document_dispacher/index/documentor/$1/$2/$3/$4'; 

//public view for brief
$route['brief/view/(:any)'] = 'brief_dispacher/index/brief/view/$1';
$route['brief'] = 'dispatcher/user_dispatcher/brief';
$route['brief/create_brief'] = 'dispatcher/user_dispatcher/brief/create_brief';
$route['brief/edit/(:any)'] = 'dispatcher/user_dispatcher/brief/edit/$1';
$route['brief/view_brief/(:any)'] = 'dispatcher/user_dispatcher/brief/view_brief/$1';
$route['brief/view_brief/(:any)/(:any)'] = 'dispatcher/user_dispatcher/brief/view_brief/$1/$2';


$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */