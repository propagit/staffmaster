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

$route['staff/(:any)'] = 'dispatcher/user_dispatcher/staff/$1';

$route['client/(:any)'] = 'dispatcher/user_dispatcher/client/$1';
$route['job/(:any)'] = 'dispatcher/user_dispatcher/job/$1';
$route['job/(:any)/(:any)'] = 'dispatcher/user_dispatcher/job/$1/$2';
$route['job/(:any)/(:any)/(:any)'] = 'dispatcher/user_dispatcher/job/$1/$2/$3';
$route['job/(:any)/(:any)/(:any)/(:any)'] = 'dispatcher/user_dispatcher/job/$1/$2/$3/$4';
$route['job/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'dispatcher/user_dispatcher/job/$1/$2/$3/$4/$5';
$route['attribute/(:any)'] = 'dispatcher/user_dispatcher/attribute/$1';
$route['attribute/(:any)/(:any)'] = 'dispatcher/user_dispatcher/attribute/$1/$2';
$route['attribute/(:any)/(:any)/(:any)'] = 'dispatcher/user_dispatcher/attribute/$1/$2/$3';

$route['(privacy-policy|terms-conditions|term-of-use)'] = 'dispatcher/user_dispatcher/page/$1';



$route['warranty/(:any)'] = 'dispatcher/user_dispatcher/warranty/$1';


$route['(dashboard|product|warranty|job|profile|config|resource)'] = 'dispatcher/user_dispatcher/$1';

$route['admin'] = 'dispatcher/admin_dispatcher';

$route['admin/login'] = 'auth/login_admin';
$route['admin/logout'] = 'auth/logout_admin';

$route['admin/(:any)'] = 'dispatcher/admin_dispatcher/$1';


//form builder
$route['formbuilder'] = 'dispatcher/user_dispatcher/formbuilder';

//documentor
//$route['documentor'] = 'dispatcher/documentor_dispacher';
$route['documentor/(:any)'] = 'dispatcher/documentor_dispacher/documentor/$1';
$route['documentor/(:any)/(:any)'] = 'dispatcher/documentor_dispacher/documentor/$1/$2';
$route['documentor/(:any)/(:any)/(:any)'] = 'dispatcher/documentor_dispacher/documentor/$1/$2/$3';
$route['documentor/(:any)/(:any)/(:any)/(:any)'] = 'dispatcher/documentor_dispacher/documentor/$1/$2/$3/$4';


$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */