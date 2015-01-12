<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

# Include constant from public application
include('./../app_public/config/constants.php');

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


/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
define('SMTEAM_EMAIL','team@staffbooks.com');

$temp_sub_domain = explode(".",$_SERVER['HTTP_HOST']);
$sub_domain = array_shift($temp_sub_domain);
define('SUBDOMAIN', $sub_domain);
define('UPLOADS_PATH' , './user_assets/'.$sub_domain.'/uploads');
define('EXPORTS_PATH' , './user_assets/'.$sub_domain.'/exports');
define('UPLOADS_URL','user_assets/'.$sub_domain.'/uploads');
define('EXPORTS_URL' , 'user_assets/'.$sub_domain.'/exports');
define('CUR_USER_ASSETS_URL','user_assets/'.$sub_domain);
define('CUR_USER_ASSETS_PATH','./user_assets/'.$sub_domain);

define('GOOGLE_MAP_API', 'AIzaSyBXS2w40hmb0AKyCIRTj8AaVHSFQ4cnYEQ');

define('COLOUR_PRIM', '#00b1eb');
define('COLOUR_SECO', '#ffffff');
define('COLOUR_ROLL', '#2a6496');
define('TEXT_COLOUR', '#3d3d3d');

define('CLIENT_ACTIVE', 1);
define('CLIENT_INACTIVE', -1);
define('CLIENT_DELETED', -2);

define('ACTIVE', 1);
define('INACTIVE', 0);
define('DELETED', -1);

define('USER_DELETED', -2);

define('STAFF_DELETED', -2);
define('STAFF_INACTIVE', -1);
define('STAFF_PENDING', 0);
define('STAFF_ACTIVE', 1);

define('IMG_THUMB_SIZE', 216);

define('GENDER_MALE', 'm');
define('GENDER_FEMALE', 'f');

define('JOB_DELETED', -1);
define('JOB_COMPLETED', 1);

define('SHIFT_DELETED', -2);
define('SHIFT_REJECTED', -1);
define('SHIFT_UNASSIGNED', 0);
define('SHIFT_UNCONFIRMED', 1);
define('SHIFT_CONFIRMED', 2);
define('SHIFT_FINISHED', 3);

define('TIMESHEET_DELETED', -1);
define('TIMESHEET_PENDING', 0);
define('TIMESHEET_SUBMITTED', 1);
define('TIMESHEET_APPROVED', 2);
define('TIMESHEET_BATCHED', 3);
define('TIMESHEET_PROCESSING', 4);
define('TIMESHEET_PAID', 5);

define('TIMESHEET_EMAIL_SENT',1);
define('TIMESHEET_EMAIL_NOT_SENT',0);
define('SUPERVISOR_TIMESHEET_SALT','sb-sp');
define('STAFF_TIMESHEET_SALT','sb-sf');
define('TIMESHEET_STAFF_KEY_TYPE','sf');
define('TIMESHEET_SUPERVISOR_KEY_TYPE','sp');

define('PAYRUN_DELETED', -1);
define('PAYRUN_PENDING', 0);
define('PAYRUN_READY', 1);
define('PAYRUN_GENERATED', 2);
define('PAYRUN_PAID', 3);

define('INVOICE_DELETED', -1);
define('INVOICE_PENDING', 0);
define('INVOICE_READY', 1);
define('INVOICE_GENERATED', 2);
define('INVOICE_PAID', 3);

define('EXPENSE_UNPAID', 0);
define('EXPENSE_PAID', 1);
define('EXPENSE_DELETED', -1);

define('PAYRATE_DELETED', -1);

define('STAFF_TFN', 1);
define('STAFF_ABN', 2);

define('APPLICANT_ACCEPTED', 1);
define('APPLICANT_REJECTED', -1);

define('GST_NO', 0);
define('GST_YES', 1);
define('GST_ADD', 2);
define('TAX_FREE', 3);

define('STAFF_PREFIX', 'SBEMP');
define('CLIENT_PREFIX', 'SBCUS');

define('LOG_WATCHED', 1);

define('DEV_CK_TOOLS',"['Bold', 'Italic', 'Underline', 'Strike'],[ 'NumberedList', 'BulletedList','-','JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],['Link', 'Unlink'],['Font'],['FontSize' ],[ 'TextColor', 'BGColor'],['Source']");
define('LIVE_CK_TOOLS',"['Bold', 'Italic', 'Underline', 'Strike'],[ 'NumberedList', 'BulletedList','-','JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],['Link', 'Unlink'],['Font'],['FontSize' ],[ 'TextColor', 'BGColor']");

//records per page
define('SHIFTS_PER_LOAD', 10);
define('CLIENTS_PER_PAGE',150);
define('STAFF_PER_PAGE',50);
define('DEFAULT_PER_PAGE',50);
define('PAYRUN_PER_PAGE',50);
define('VENUES_PER_PAGE',50);
define('INVOICE_PER_PAGE',50);
define('CONVERSATION_PER_PAGE',25);
define('BRIEF_PER_PAGE',50);
define('SUPPORT_PER_PAGE',25);
//email template id
define('WELCOME_EMAIL_TEMPLATE_ID',1);
define('ROSTER_UPDATE_EMAIL_TEMPLATE_ID',2);
define('APPLY_FOR_SHIFT_EMAIL_TEMPLATE_ID',3);
define('SHIFT_REMINDER_EMAIL_TEMPLATE_ID',4);
define('WORK_CONFIRMATION_EMAIL_TEMPLATE_ID',5);
define('FORGOT_PASSWORD_EMAIL_TEMPLATE_ID',6);
define('CLIENT_INVOICE_EMAIL_TEMPLATE_ID',7);
define('CLIENT_QUOTE_EMAIL_TEMPLATE_ID',8);
define('BRIEF_EMAIL_TEMPLATE_ID',9);
define('TIMESHEET_EMAIL_TEMPLATE_ID',10);
/* End of file constants.php */
/* Location: ./application/config/constants.php */