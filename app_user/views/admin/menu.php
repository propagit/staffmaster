<?
$page = $this->uri->segment(1) ? $this->uri->segment(1) : 'dashboard';
$menu = array(
	array('path' => '#', 'icon' => 'icon-staff', 'title' => 'Manage Staff', 'sub' => array(
		array('path' => 'staff/search', 'icon' => 'icon-searchStaff', 'title' => 'Search Staff'),
		array('path' => 'staff/add', 'icon' => 'icon-addStaff', 'title' => 'Add Staff'),
		array('path' => 'staff/import', 'icon' => 'icon-importStaff', 'title' => 'Import Staff'),
		array('path' => 'form/applicant', 'icon' => 'icon-applicantStaff', 'title' => 'Applicants')
	)),
	array('path' => '#', 'icon' => 'icon-client', 'title' => 'Manage Clients', 'sub' => array(
		array('path' => 'client/search', 'icon' => 'icon-searchClient', 'title' => 'Search Clients'),
		array('path' => 'client/add', 'icon' => 'icon-addClient', 'title' => 'Add Client'),
		array('path' => 'client/import', 'icon' => 'icon-importClient', 'title' => 'Import Client')
	)),
	array('path' => '#', 'icon' => 'icon-jobs', 'title' => 'Manage Jobs', 'sub' => array(
		array('path' => 'job/search', 'icon' => 'icon-searchJobs', 'title' => 'Search Jobs'),
		array('path' => 'job/create', 'icon' => 'icon-addJobs', 'title' => 'Create Job'),
		array('path' => 'job/calendar', 'icon' => 'fa-calendar', 'title' => 'Company Calendar')
	)),
	array('path' => '#', 'icon' => 'icon-attributes', 'title' => 'Edit Attributes', 'sub' => array(		
		array('path' => 'attribute/payrate', 'icon' => 'icon-attributesPayrate', 'title' => 'Pay Rates'),
		array('path' => 'attribute/role', 'icon' => 'icon-roles', 'title' => 'Roles'),
		array('path' => 'attribute/venue', 'icon' => 'icon-attributesVenues', 'title' => 'Venues'),
		array('path' => 'attribute/uniform', 'icon' => 'icon-attributesUniforms', 'title' => 'Uniforms'),
		array('path' => 'attribute/custom', 'icon' => 'icon-attributesCustom', 'title' => 'Custom Attributes'),
		array('path' => 'attribute/group', 'icon' => 'icon-attributesGroups', 'title' => 'Groups')
	)),
	array('path' => '#', 'icon' => 'fa-usd', 'title' => 'Payroll / Accounts', 'sub' => array(
		array('path' => 'report', 'icon' => 'icon-accountsReports', 'title' => 'Accounts Reports'),
		array('path' => 'timesheet', 'icon' => 'icon-accountsTimesheetss', 'title' => 'Time Sheets'),
		array('path' => 'payrun', 'icon' => 'icon-accountsPayrun', 'title' => 'Pay Run'),
		array('path' => 'expense', 'icon' => 'icon-accountsExpense', 'title' => 'Staff Expenses'),
		array('path' => 'invoice', 'icon' => 'icon-accountsInvoices', 'title' => 'Client Invoices'),
		array('path' => 'account/topup', 'icon' => 'icon-accountsCREDITS', 'title' => 'Buy Credits'),
		#array('path' => '#', 'icon' => 'fa-phone', 'title' => 'Buy SMS Credits')
	)),
	array('path' => '#', 'icon' => 'fa-lightbulb-o', 'title' => 'Training Centre', 'sub' => array(
		array('path' => 'forum', 'icon' => 'fa-comments-o', 'title' => 'Conversations'),
		array('path' => 'brief', 'icon' => 'icon-trainingBrief', 'title' => 'Brief Builder'),
		array('path' => 'http://resources.staffbooks.com', 'icon' => 'fa-question', 'title' => 'User Guide'),
		#array('path' => '#', 'icon' => 'fa-video-camera', 'title' => 'Training Video'),
		#array('path' => '#', 'icon' => 'fa-folder-open-o', 'title' => 'Training Centre'),
		#array('path' => '#', 'icon' => 'fa-refresh', 'title' => 'Create Work Process'),
		#array('path' => '#', 'icon' => 'fa-paperclip', 'title' => 'Create Document'),
		#array('path' => '#', 'icon' => 'fa-bar-chart-o', 'title' => 'Create Survey'),
		#array('path' => '#', 'icon' => 'fa-youtube-play', 'title' => 'Create Video'),
		#array('path' => '#', 'icon' => 'fa-check', 'title' => 'Create Test'),
		#array('path' => '#', 'icon' => 'fa-file-o', 'title' => 'Create Webpage')
	)),
	array('path' => '#', 'icon' => 'fa-gears', 'title' => 'System Settings', 'sub' => array(
		array('path' => 'setting/company', 'icon' => 'icon-company', 'title' => 'Company Profile'),
		array('path' => 'form', 'icon' => 'icon-formBuilder', 'title' => 'Form Builder'),
		array('path' => 'export', 'icon' => 'icon-exportTemplates', 'title' => 'Export Templates'),
		array('path' => 'email', 'icon' => 'fa-envelope', 'title' => 'eMail Templates'),
		array('path' => 'sms', 'icon' => 'fa-mobile', 'title' => 'SMS Settings'),
		array('path' => 'setting/system_settings', 'icon' => 'fa-cog', 'title' => 'Other Settings'),
		#array('path' => 'setting/system_styles', 'icon' => 'fa-tint', 'title' => 'System Styles'),		
		array('path' => 'setting/integration', 'icon' => 'icon-accountIntergration', 'title' => 'Accounts Integration'), 
		array('path' => 'log', 'icon' => 'icon-activityLogs', 'title' => 'Activity Logs'),
		array('path' => 'support/admin_support', 'icon' => 'icon-support', 'title' => 'Support')
	))
);
?>
<div id="nav-wrap">
	<div class="row desktop-visible">
    	<div class="col-md-12">
            <ul class="nav nav-pills top-nav">
            <? foreach($menu as $item) { ?>
                 <li class="dropdown <?=($page == $item['path']) ? 'active' : '';?>">
                    <a class="dropdown-toggle" data-toggle="dropdown"  href="<?=base_url() . $item['path'];?>">
                      <i class="fa <?=$item['icon'];?>"></i><span class="nav-label"><?=$item['title'];?></span> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                      <? foreach($item['sub'] as $sub_item) { ?>
                        <li><a <?=($sub_item['title'] == 'User Guide') ? 'target="_blank"' : '';?> href="<?=($sub_item['title'] == 'User Guide') ? $sub_item['path'] : base_url() . $sub_item['path'];?>"><i class="fa <?=$sub_item['icon'];?>"></i><span class="nav-label"><?=$sub_item['title'];?></span></a></li>
                      <? } ?>
                    </ul>
                  </li>
            <? } ?>
            </ul>
        </div>
    </div>
    
    
    
    <!-- begin mob nav-->
    <div class="row desktop-hidden">
        <div class="navbar navbar-inverse">
            <div class="col-md-12">
                <button class="btn btn-navbar" data-target=".nav-collapse" data-toggle="collapse" type="button">
                   <i class="fa fa-align-justify"></i>
                </button>
                <span class="mob-menu-head">MENU <i class="fa fa-angle-right"></i></span>
            </div>
            <div class="nav-collapse collapse" id="nav-collapse-header" style="height: auto;">
                <ul class="nav top-nav">
                     <? foreach($menu as $item) { ?>
                         <li class="dropdown <?=($page == $item['path']) ? 'active' : '';?>">
                            <a class="dropdown-toggle" data-toggle="dropdown"  href="<?=base_url() . $item['path'];?>">
                              <i class="fa <?=$item['icon'];?>"></i><span class="nav-label"><?=$item['title'];?></span> <i class="fa fa-caret-down pull"></i><i class="fa fa-angle-down pull"></i>
                            </a>
                            <ul class="dropdown-menu">
                              <? foreach($item['sub'] as $sub_item) { ?>
                                <li><a href="<?=base_url() . $sub_item['path'];?>"><i class="fa">-</i><span class="nav-label"><?=$sub_item['title'];?></span></a></li>
                              <? } ?>
                            </ul>
                          </li>
                    <? } ?>
                </ul>
            </div>

        </div>
    </div>
    <!-- end mob nv-->
</div>
