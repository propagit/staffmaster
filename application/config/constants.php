<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


define('COLOR_PRIM', '#1868b1');
define('COLOR_SECO', '#024c93');
define('COLOR_HILI', '#ffffff');
define('COLOR_MIDT', '#8799a3');
define('COLOR_DARK', '#000000');



define('STAFF_DELETED', -2);
define('STAFF_INACTIVE', -1);
define('STAFF_PENDING', 0);
define('STAFF_ACTIVE', 2);

define('GENDER_MALE', 'm');
define('GENDER_FEMALE', 'f');

define('SHIFT_DELETED', -2);
define('SHIFT_REJECTED', -1);
define('SHIFT_UNASSIGNED', 0);
define('SHIFT_UNCONFIRMED', 1);
define('SHIFT_CONFIRMED', 2);

/* End of file constants.php */
/* Location: ./application/config/constants.php */