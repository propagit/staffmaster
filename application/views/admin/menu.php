<?
	$menu = array(
		array(
			'path' => 'dashboard',
			'label' => 'Dashboard'
		),
		array(
			'path' => 'product',
			'label' => 'Manage Products',
			'sub' => array(
				'category' => 'Categories',
				'brand' => 'Brands'
			)
		),
		array(
			'path' => 'order',
			'label' => 'Orders'
		),
		array(
			'path' => 'user',
			'label' => 'Manage Users',
		),
		array(
			'path' => 'resource',
			'label' => 'Resources Management'
		),
		array(
			'path' => 'page',
			'label' => 'Content Management'
		)
	);
	
	$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 'dashboard';
	$sec = $this->uri->segment(3);
?>
<ul class="nav nav-tabs nav-stacked">
	<? foreach($menu as $link) { ?>
	<li<?=($page == $link['path']) ? ' class="active"' : '';?>>
		<a href="<?=base_url() . 'admin/' . $link['path'];?>">
			<? if (isset($link['sub']) && ($page == $link['path'])) { ?>
			<i class="icon-chevron-down<?=($page == $link['path']) ? ' icon-white' : '';?>"></i>
			<? } else { ?>
			<i class="icon-chevron-<?=($page == $link['path']) ? 'right icon-white' : 'left';?>"></i> 
			<? } ?>
			<?=$link['label'];?></a>
		<? if (isset($link['sub']) && ($page == $link['path'])) { ?>
			<ul class="nav nav-tabs nav-stacked nav-sub">
				<? foreach($link['sub'] as $key => $value) { ?>
				<li<?=($sec == $key) ? ' class="active"' : '';?>><a href="<?=base_url() . 'admin/' . $link['path'] . '/' . $key;?>"><i class="icon-chevron-<?=($sec == $key) ? 'right' : 'left';?> icon-white"></i> <?=$value;?></a></li>
				<? } ?>
			</ul>
		<? } ?>
	</li>
	<? } ?>
</ul>