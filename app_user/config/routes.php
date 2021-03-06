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
$route['forgot-password'] = 'forgot_password';



$modules = array('job', 'staff', 'client', 'roster', 'work', 'timesheet', 'invoice', 'payrun', 'expense', 'setting', 'export', 'email', 'report', 'forum', 'log','account','support','user_guide', 'wizard', 'form', 'attribute', 'sms', 'induction','user_notes','lookbook');
$path = implode('|', $modules);
$route['(' . $path . ')'] = 'dispatcher/user_dispatcher/$1';
$route['(' . $path . ')/(:any)'] = 'dispatcher/user_dispatcher/$1/$2';
$route['(' . $path . ')/(:any)/(:any)'] = 'dispatcher/user_dispatcher/$1/$2/$3';
$route['(' . $path . ')/(:any)/(:any)/(:any)'] = 'dispatcher/user_dispatcher/$1/$2/$3/$4';
$route['(' . $path . ')/(:any)/(:any)/(:any)/(:any)'] = 'dispatcher/user_dispatcher/$1/$2/$3/$4/$5';
$route['(' . $path . ')/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'dispatcher/user_dispatcher/$1/$2/$3/$4/$5/$6';

$route['public/form/(:any)'] = 'public_dispatcher/form/$1';
$route['public/form/(:any)/(:any)'] = 'public_dispatcher/form/$1/$2';


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
$route['brief/view_information_sheet'] = 'dispatcher/user_dispatcher/brief/view_information_sheet';
$route['brief/view_information_sheet/(:any)'] = 'dispatcher/user_dispatcher/brief/view_information_sheet/$1';

# public view for timesheet approval
$route['pts/ls_ts'] = 'public_timesheet_dispatcher/list_timesheet';
$route['pts/ls_ts/(:any)'] = 'public_timesheet_dispatcher/list_timesheet/$1';
$route['pts/ls_ts/(:any)/(:any)'] = 'public_timesheet_dispatcher/list_timesheet/$1/$2';
$route['pts/ap_ts'] = 'public_timesheet_dispatcher/approve_timesheet';
$route['pts/rj_ts'] = 'public_timesheet_dispatcher/reject_timsheet';

# routes for timesheet ajax function that are public and accessed by encrypted url
$ts_ajax_funcs = array(
					'update_timesheet_start_time',
					'update_timesheet_finish_time',
					'refresh_timesheet',
					'load_ts_breaks',
					'add_ts_break',
					'update_ts_breaks',
					'load_expenses_modal',
					'list_expenses',
					'add_expense',
					'delete_expense',
					'details'
					);
foreach($ts_ajax_funcs as $func){
$route['pts/' .$func] = 'public_timesheet_dispatcher/' . $func;
$route['pts/' . $func . '/(:any)'] = 'public_timesheet_dispatcher/' . $func . '/$1';
}


# lookbook
#$route['plb'] = 'public_lookbook_dispatcher/list_lookbook';
$route['plb/staffbook/(:any)'] = 'public_lookbook_dispatcher/list_lookbook/$1';
$route['plb/preview/(:any)'] = 'public_lookbook_dispatcher/preview/$1';
$route['plb/update_like_status'] = 'public_lookbook_dispatcher/update_like_status';
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
