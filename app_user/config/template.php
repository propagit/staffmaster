<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Active template
|--------------------------------------------------------------------------
|
| The $template['active_template'] setting lets you choose which template
| group to make active.  By default there is only one group (the
| "default" group).
|
*/
$template['active_template'] = 'login';

/*
|--------------------------------------------------------------------------
| Explaination of template group variables
|--------------------------------------------------------------------------
|
| ['template'] The filename of your master template file in the Views folder.
|   Typically this file will contain a full XHTML skeleton that outputs your
|   full template or region per region. Include the file extension if other
|   than ".php"
| ['regions'] Places within the template where your content may land.
|   You may also include default markup, wrappers and attributes here
|   (though not recommended). Region keys must be translatable into variables
|   (no spaces or dashes, etc)
| ['parser'] The parser class/library to use for the parse_view() method
|   NOTE: See http://codeigniter.com/forums/viewthread/60050/P0/ for a good
|   Smarty Parser that works perfectly with Template
| ['parse_template'] FALSE (default) to treat master template as a View. TRUE
|   to user parser (see above) on the master template
|
| Region information can be extended by setting the following variables:
| ['content'] Must be an array! Use to set default region content
| ['name'] A string to identify the region beyond what it is defined by its key.
| ['wrapper'] An HTML element to wrap the region contents in. (We
|   recommend doing this in your template file.)
| ['attributes'] Multidimensional array defining HTML attributes of the
|   wrapper. (We recommend doing this in your template file.)
|
| Example:
| $template['default']['regions'] = array(
|    'header' => array(
|       'content' => array('<h1>Welcome</h1>','<p>Hello World</p>'),
|       'name' => 'Page Header',
|       'wrapper' => '<div>',
|       'attributes' => array('id' => 'header', 'class' => 'clearfix')
|    )
| );
|
*/

/*
|--------------------------------------------------------------------------
| Default Template Configuration (adjust this or create your own)
|--------------------------------------------------------------------------
*/

$template['default']['template'] = 'template';
$template['default']['regions'] = array(
   'header',
   'user_nav',
   'main_area',
   'footer',
);
$template['default']['parser'] = 'parser';
$template['default']['parser_method'] = 'parse';
$template['default']['parse_template'] = FALSE;

$template['login'] = array(
	'template' => 'login',
	'regions' => array(
		'check_browser',
		'content',
		'msg_error',
		'title'
	)
);
$template['forgot_password'] = array(
	'template' => 'forgot_password',
	'regions' => array(
		'content',
		'msg',
		'title'
	)
);
$template['user'] = array(
	'template' => 'user/default',
	'regions' => array(
		'title',
		'menu',
		'content',
	)
);
$template['admin'] = array(
	'template' => 'admin/default',
	'regions' => array(
		'title',
		'menu',
		'content',
	)
);
$template['documents'] = array(
	'template' => 'documents/default',
	'regions' => array(
		'title',
		'menu',
		'content',
	)
);
$template['staff'] = array(
	'template' => 'staff/default',
	'regions' => array(
		'title',
		'menu',
		'content',
	)
);
$template['client'] = array(
	'template' => 'client/default',
	'regions' => array(
		'title',
		'menu',
		'content',
	)
);
$template['invoice'] = array(
	'template' => 'admin/invoice',
	'regions' => array(
		'title',
		'menu',
		'content'
	)
);
$template['brief'] = array(
	'template' => 'brief/brief_viewer',
	'regions' => array(
		'title',
		'menu',
		'content'
	)
);
$template['induction'] = array(
	'template' => 'induction',
	'regions' => array(
		'title',
		'menu',
		'content'
	)
);
$template['public_timesheet'] = array(
	'template' => 'public/timesheet/default_template',
	'regions' => array(
		'title',
		'content'
	)
);
$template['public_lookbook'] = array(
	'template' => 'public/lookbook/default_template',
	'regions' => array(
		'title',
		'menu',
		'content'
	)
);

/* End of file template.php */
/* Location: ./system/application/config/template.php */
