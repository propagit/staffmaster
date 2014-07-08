<?
$page = $this->uri->segment(1) ? $this->uri->segment(1) : 'dashboard';
$menu = array(
	array('path' => '#', 'icon' => 'fa-users', 'title' => 'Manage Staff', 'sub' => array(
		array('path' => 'staff/search', 'icon' => 'fa-search', 'title' => 'Search Staff'),
		array('path' => 'staff/add', 'icon' => 'fa-plus', 'title' => 'Add Staff'),
		array('path' => 'staff/import', 'icon' => 'fa-upload', 'title' => 'Import Staff'),
		array('path' => 'form/applicant', 'icon' => 'fa-file-text-o', 'title' => 'Applicants')
	)),
	array('path' => '#', 'icon' => 'fa-book', 'title' => 'Manage Clients', 'sub' => array(
		array('path' => 'client/search', 'icon' => 'fa-search', 'title' => 'Search Clients'),
		array('path' => 'client/add', 'icon' => 'fa-plus', 'title' => 'Add Client'),
		array('path' => 'client/import', 'icon' => 'fa-upload', 'title' => 'Import Client')
	)),
	array('path' => '#', 'icon' => 'fa-folder-open', 'title' => 'Manage Jobs', 'sub' => array(
		array('path' => 'job/search', 'icon' => 'fa-search', 'title' => 'Search Jobs'),
		array('path' => 'job/create', 'icon' => 'fa-plus', 'title' => 'Create Job'),
		array('path' => 'job/calendar', 'icon' => 'fa-calendar', 'title' => 'Company Calendar')
	)),
	array('path' => '#', 'icon' => 'fa-key', 'title' => 'Edit Attributes', 'sub' => array(		
		array('path' => 'attribute/payrate', 'icon' => 'fa-usd', 'title' => 'Pay Rates'),
		array('path' => 'attribute/role', 'icon' => 'fa-star', 'title' => 'Roles'),
		array('path' => 'attribute/venue', 'icon' => 'fa-map-marker', 'title' => 'Venues'),
		array('path' => 'attribute/uniform', 'icon' => 'fa-puzzle-piece', 'title' => 'Uniforms'),
		array('path' => 'attribute/custom', 'icon' => 'fa-pencil', 'title' => 'Custom Attributes'),
		array('path' => 'attribute/group', 'icon' => 'fa-sitemap', 'title' => 'Groups')
	)),
	array('path' => '#', 'icon' => 'fa-usd', 'title' => 'Payroll / Accounts', 'sub' => array(
		array('path' => 'report', 'icon' => 'fa-dashboard', 'title' => 'Accounts Reports'),
		array('path' => 'timesheet', 'icon' => 'fa-thumbs-up', 'title' => 'Time Sheets'),
		array('path' => 'payrun', 'icon' => 'fa-stack-exchange', 'title' => 'Pay Run'),
		array('path' => 'expense', 'icon' => 'fa-dollar', 'title' => 'Staff Expenses'),
		array('path' => 'invoice', 'icon' => 'fa-file-text', 'title' => 'Client Invoices'),
		array('path' => 'account/topup', 'icon' => 'fa-credit-card', 'title' => 'Buy Credits'),
		#array('path' => '#', 'icon' => 'fa-phone', 'title' => 'Buy SMS Credits')
	)),
	array('path' => '#', 'icon' => 'fa-lightbulb-o', 'title' => 'Training Centre', 'sub' => array(
		array('path' => 'forum', 'icon' => 'fa-comments-o', 'title' => 'Conversations'),
		array('path' => 'brief', 'icon' => 'fa-book', 'title' => 'Brief Builder'),
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
		array('path' => 'setting/company', 'icon' => 'fa-flag', 'title' => 'Company Profile'),
		array('path' => 'form', 'icon' => 'fa-file-text-o', 'title' => 'Form Builder'),
		array('path' => 'export', 'icon' => 'fa-list-alt', 'title' => 'Export Templates'),
		array('path' => 'email', 'icon' => 'fa-envelope', 'title' => 'eMail Templates'),
		#array('path' => 'setting/system_styles', 'icon' => 'fa-tint', 'title' => 'System Styles'),		
		array('path' => 'log', 'icon' => 'fa-tasks', 'title' => 'Activity Logs'),
		array('path' => 'support/admin_support', 'icon' => 'fa-phone', 'title' => 'Support'),
		array('path' => 'setting/system_settings', 'icon' => 'fa-cog', 'title' => 'System Settings')
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
