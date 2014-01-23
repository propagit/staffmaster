<?
$page = $this->uri->segment(1) ? $this->uri->segment(1) : 'dashboard';
$menu = array(
	array('path' => '#', 'icon' => 'group', 'title' => 'Staff', 'sub' => array(
		array('path' => 'staff/search', 'icon' => 'search', 'title' => 'Search Staff'),
		array('path' => 'staff/add', 'icon' => 'plus-sign', 'title' => 'Add Staff'),
		array('path' => '#', 'icon' => 'magnet', 'title' => 'Assign Assets')
	)),
	array('path' => '#', 'icon' => 'book', 'title' => 'Clients', 'sub' => array(
		array('path' => 'client/search', 'icon' => 'search', 'title' => 'Search Client'),
		array('path' => 'client/add', 'icon' => 'plus-sign', 'title' => 'Add Client'),
	)),
	array('path' => '#', 'icon' => 'folder-open', 'title' => 'Jobs', 'sub' => array(
		array('path' => 'job/calendar', 'icon' => 'calendar', 'title' => 'Calendar View'),	
		array('path' => 'job/search', 'icon' => 'search', 'title' => 'Search Jobs'),
		array('path' => 'job/create', 'icon' => 'plus-sign', 'title' => 'Create Job')
	)),
	array('path' => '#', 'icon' => 'key', 'title' => 'Attributes', 'sub' => array(		
		array('path' => 'attribute/payrate', 'icon' => 'usd', 'title' => 'Pay Rates'),
		array('path' => 'attribute/department', 'icon' => 'sitemap', 'title' => 'Departments'),
		array('path' => 'attribute/role', 'icon' => 'star', 'title' => 'Roles'),
		//array('path' => 'attribute/location', 'icon' => 'globe', 'title' => 'Locations'),
		array('path' => 'attribute/venue', 'icon' => 'map-marker', 'title' => 'Venues'),
		array('path' => 'attribute/uniform', 'icon' => 'puzzle-piece', 'title' => 'Uniforms'),	
		/* array('path' => 'attribute/option', 'icon' => 'question-sign', 'title' => 'Options') */
	)),
	array('path' => '#', 'icon' => 'usd', 'title' => 'Payroll / Accounts', 'sub' => array(
		array('path' => '#', 'icon' => 'dashboard', 'title' => 'Accounts Dashboard'),
		array('path' => '#', 'icon' => 'thumbs-up', 'title' => 'Approve Shifts'),
		array('path' => '#', 'icon' => 'search', 'title' => 'Search Accounts'),
		array('path' => '#', 'icon' => 'stackexchange', 'title' => 'Pay Staff'),
		array('path' => '#', 'icon' => 'file-text', 'title' => 'Client Invoices'),
		array('path' => '#', 'icon' => 'plus-sign-alt', 'title' => 'Create Invoices'),
		array('path' => '#', 'icon' => 'gears', 'title' => 'Accounts Settings'),
		array('path' => '#', 'icon' => 'credit-card', 'title' => 'Pay Bills'),
		array('path' => '#', 'icon' => 'phone', 'title' => 'Buy SMS Credits')
	)),
	array('path' => '#', 'icon' => 'lightbulb', 'title' => 'Training Centre', 'sub' => array(
		array('path' => '#', 'icon' => 'question-sign', 'title' => 'User Guide'),
		array('path' => '#', 'icon' => 'facetime-video', 'title' => 'Training Video'),
		array('path' => '#', 'icon' => 'folder-open-alt', 'title' => 'Training Centre'),
		array('path' => '#', 'icon' => 'refresh', 'title' => 'Create Work Process'),
		array('path' => '#', 'icon' => 'paperclip', 'title' => 'Create Document'),
		array('path' => '#', 'icon' => 'bar-chart', 'title' => 'Create Survey'),
		array('path' => '#', 'icon' => 'youtube-play', 'title' => 'Create Video'),
		array('path' => '#', 'icon' => 'check', 'title' => 'Create Test'),
		array('path' => '#', 'icon' => 'file-alt', 'title' => 'Create Webpage'),
	)),
	array('path' => '#', 'icon' => 'gears', 'title' => 'System Settings', 'sub' => array(
		array('path' => 'profile', 'icon' => 'flag', 'title' => 'Company Profile'),
		array('path' => '#', 'icon' => 'tint', 'title' => 'System Styles'),
		array('path' => '#', 'icon' => 'phone', 'title' => 'SMS Message'),
		array('path' => '#', 'icon' => 'envelope', 'title' => 'eMail Management'),
	))
);
?>
<ul class="main_nav">
	<? foreach($menu as $item) { ?>
	<li<?=($page == $item['path']) ? ' class="active"' : '';?> class="dropdown">
		<a href="<?=base_url() . $item['path'];?>" class="dropdown-toggle" data-toggle="dropdown">
			<i class="icon-<?=$item['icon'];?> icon-large"></i> <?=$item['title'];?>
			<b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
			<? foreach($item['sub'] as $sub_item) { ?>
			<li><a href="<?=base_url() . $sub_item['path'];?>"><i class="icon-<?=$sub_item['icon'];?>"></i> <?=$sub_item['title'];?></a></li>
			<? } ?>
		</ul>
	</li>
	<? } ?>
</ul>
<script>
$(function(){
	$('ul.main_nav li.dropdown').hover(function(){
		$(this).find('.dropdown-menu').stop(true,true).delay(200).show();
	}, function(){
		$(this).find('.dropdown-menu').stop(true,true).delay(200).hide();
	});
})
</script>