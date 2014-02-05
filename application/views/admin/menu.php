<?
$page = $this->uri->segment(1) ? $this->uri->segment(1) : 'dashboard';
$menu = array(
	array('path' => '#', 'icon' => 'fa-users', 'title' => 'Manage Staff', 'sub' => array(
		array('path' => 'staff/search', 'icon' => 'fa-search', 'title' => 'Search Staff'),
		array('path' => 'staff/add', 'icon' => 'fa-plus', 'title' => 'Add Staff'),
		array('path' => '#', 'icon' => 'fa-magnet', 'title' => 'Assign Assets')
	)),
	array('path' => '#', 'icon' => 'fa-book', 'title' => 'Manage Clients', 'sub' => array(
		array('path' => 'client/search', 'icon' => 'fa-search', 'title' => 'Search Client'),
		array('path' => 'client/add', 'icon' => 'fa-plus', 'title' => 'Add Client'),
	)),
	array('path' => '#', 'icon' => 'fa-folder-open', 'title' => 'Manage Jobs', 'sub' => array(
		array('path' => 'job/search', 'icon' => 'fa-search', 'title' => 'Search Jobs'),
		array('path' => 'job/create', 'icon' => 'fa-plus', 'title' => 'Create Job')
	)),
	array('path' => '#', 'icon' => 'fa-key', 'title' => 'Edit Attributes', 'sub' => array(		
		array('path' => 'attribute/payrate', 'icon' => 'fa-usd', 'title' => 'Pay Rates'),
		array('path' => 'attribute/department', 'icon' => 'fa-sitemap', 'title' => 'Departments'),
		array('path' => 'attribute/role', 'icon' => 'fa-star', 'title' => 'Roles'),
		array('path' => 'attribute/venue', 'icon' => 'fa-map-marker', 'title' => 'Venues'),
		array('path' => 'attribute/uniform', 'icon' => 'fa-puzzle-piece', 'title' => 'Uniforms')
	)),
	array('path' => '#', 'icon' => 'fa-usd', 'title' => 'Payroll / Accounts', 'sub' => array(
		array('path' => '#', 'icon' => 'fa-dashboard', 'title' => 'Accounts Dashboard'),
		array('path' => '#', 'icon' => 'fa-thumbs-up', 'title' => 'Approve Shifts'),
		array('path' => '#', 'icon' => 'fa-search', 'title' => 'Search Accounts'),
		array('path' => '#', 'icon' => 'fa-stack-exchange', 'title' => 'Pay Staff'),
		array('path' => '#', 'icon' => 'fa-file-text', 'title' => 'Client Invoices'),
		array('path' => '#', 'icon' => 'fa-plus', 'title' => 'Create Invoices'),
		array('path' => '#', 'icon' => 'fa-gears', 'title' => 'Accounts Settings'),
		array('path' => '#', 'icon' => 'fa-credit-card', 'title' => 'Pay Bills'),
		array('path' => '#', 'icon' => 'fa-phone', 'title' => 'Buy SMS Credits')
	)),
	array('path' => '#', 'icon' => 'fa-lightbulb-o', 'title' => 'Training Centre', 'sub' => array(
		array('path' => '#', 'icon' => 'fa-question', 'title' => 'User Guide'),
		array('path' => '#', 'icon' => 'fa-video-camera', 'title' => 'Training Video'),
		array('path' => '#', 'icon' => 'fa-folder-open-o', 'title' => 'Training Centre'),
		array('path' => '#', 'icon' => 'fa-refresh', 'title' => 'Create Work Process'),
		array('path' => '#', 'icon' => 'fa-paperclip', 'title' => 'Create Document'),
		array('path' => '#', 'icon' => 'fa-bar-chart-o', 'title' => 'Create Survey'),
		array('path' => '#', 'icon' => 'fa-youtube-play', 'title' => 'Create Video'),
		array('path' => '#', 'icon' => 'fa-check', 'title' => 'Create Test'),
		array('path' => '#', 'icon' => 'fa-file-o', 'title' => 'Create Webpage'),
	)),
	array('path' => '#', 'icon' => 'fa-gears', 'title' => 'System Settings', 'sub' => array(
		array('path' => 'profile', 'icon' => 'fa-flag', 'title' => 'Company Profile'),
		array('path' => '#', 'icon' => 'fa-tint', 'title' => 'System Styles'),
		array('path' => '#', 'icon' => 'fa-phone', 'title' => 'SMS Message'),
		array('path' => '#', 'icon' => 'fa-envelope', 'title' => 'eMail Management'),
	))
);
?>
<div id="nav-wrap">
	<div class="row desktop-visible">
    	<div class="col-md-12">
            <ul class="nav nav-pills">
            <? foreach($menu as $item) { ?>
                 <li class="dropdown <?=($page == $item['path']) ? 'active' : '';?>">
                    <a class="dropdown-toggle" data-toggle="dropdown"  href="<?=base_url() . $item['path'];?>">
                      <i class="fa <?=$item['icon'];?>"></i><span class="nav-label"><?=$item['title'];?></span> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                      <? foreach($item['sub'] as $sub_item) { ?>
                        <li><a href="<?=base_url() . $sub_item['path'];?>"><i class="fa <?=$sub_item['icon'];?>"></i><span class="nav-label"><?=$sub_item['title'];?></span></a></li>
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
                <ul class="nav">
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
            
        
        
        
        
        
        


