<?
$page = $this->uri->segment(1) ? $this->uri->segment(1) : 'dashboard';
$menu = array(
	array('path' => '#', 'icon' => 'dashboard', 'title' => 'Dashboard', 'sub' => array(
		//array('path' => 'staff/search', 'icon' => 'search', 'title' => 'Search Staff'),
		//array('path' => 'staff/add', 'icon' => 'plus-sign', 'title' => 'Add Staff'),
		//array('path' => '#', 'icon' => 'magnet', 'title' => 'Assign Assets')
	)),
	array('path' => '#', 'icon' => 'user', 'title' => 'Your Profile', 'sub' => array(
		//array('path' => 'client/search', 'icon' => 'search', 'title' => 'Search Client'),
		//array('path' => 'client/add', 'icon' => 'plus-sign', 'title' => 'Add Client'),
	)),
	array('path' => '#', 'icon' => 'calendar', 'title' => 'Your Roster', 'sub' => array(
		//array('path' => 'job/calendar', 'icon' => 'calendar', 'title' => 'Calendar View'),	
		//array('path' => 'job/search', 'icon' => 'search', 'title' => 'Search Jobs'),
		//array('path' => 'job/create', 'icon' => 'plus-sign', 'title' => 'Create Job')
	)),
	array('path' => '#', 'icon' => 'thumbs-o-up', 'title' => 'Apply For Work', 'sub' => array(		
		
	)),
	array('path' => '#', 'icon' => 'clock-o', 'title' => 'Time Sheets', 'sub' => array(
		//array('path' => '#', 'icon' => 'dashboard', 'title' => 'Accounts Dashboard'),
		
	)),
	array('path' => '#', 'icon' => 'book', 'title' => 'Training Centre', 'sub' => array(
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
	array('path' => '#', 'icon' => 'phone', 'title' => 'Support', 'sub' => array(
		
	))
);
?>
<ul class="main_nav">
	<? foreach($menu as $item) { ?>
	<li<?=($page == $item['path']) ? ' class="active"' : '';?> class="dropdown">
		<a href="<?=base_url() . $item['path'];?>" class="dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-<?=$item['icon'];?> icon-large"></i> <?=$item['title'];?>
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