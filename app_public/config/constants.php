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

define('USER_ASSETS_PATH', 'user_assets');
define('USER_PREFIX_DB', 'user_db_');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('MASTER_DB', 'smcloud');

define('SITE_NAME', 'StaffBooks');
define('LIVE_SERVER', false);
define('VIRTUAL_NUMBER', '447624803738');
define('CBF_USER', 'staffbooks');
define('CBF_PASS', 'staffb00ks');
define('SMS_PRICE', 0.1); # 10 cents per sms

define('MYOB_API_KEY', '6k2r6jwjj2a7t9qmh9n338w2');
define('MYOB_API_SECRET', 'EsJWfB3HXHGDke8RmZtpSfeS');

define('ACCOUNT_ACTIVE', 1);
define('ACCOUNT_INACTIVE', -1);
define('ACCOUNT_BANNED', -2);

/* End of file constants.php */
/* Location: ./application/config/constants.php */
