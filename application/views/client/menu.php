<?
$page = $this->uri->segment(1) ? $this->uri->segment(1) : 'dashboard';
$menu = array(
	array('path' => 'job', 'icon' => 'fa-calendar', 'title' => 'Manage Jobs', 'sub' => array(
		array('path' => 'job/calendar', 'icon' => 'fa-calendar', 'title' => 'Company Calendar'),
		array('path' => 'job/create', 'icon' => 'fa-plus', 'title' => 'Create Job'),
		array('path' => 'job/search', 'icon' => 'fa-search', 'title' => 'Search Jobs')
	)),
	array('path' => 'account', 'icon' => 'fa-user', 'title' => 'Your Profile', 'sub' => array(
	)),
	array('path' => 'staff', 'icon' => 'fa-search', 'title' => 'Search Our Staff', 'sub' => array(
	)),
	array('path' => 'invoice', 'icon' => 'fa-clock-o', 'title' => 'Your Invoices', 'sub' => array(
	)),
	array('path' => 'support', 'icon' => 'fa-phone', 'title' => 'Support', 'sub' => array(		
	))
);
?>
<div id="nav-wrap">
	<div class="row desktop-visible">
		<div class="col-md-12">
			<ul class="nav nav-pills">
			<? foreach($menu as $item) { ?>
				<? if (count($item['sub']) > 0) { ?> 
				<li class="dropdown <?=($page == $item['path']) ? 'active' : '';?>">
					<a class="dropdown-toggle" data-toggle="dropdown"  href="<?=base_url() . $item['path'];?>">
						<i class="fa <?=$item['icon'];?>"></i><span class="nav-label"><?=$item['title'];?></span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
					<? foreach($item['sub'] as $sub_item) { ?>
						<li>
							<a href="<?=base_url() . $sub_item['path'];?>">
								<i class="fa <?=$sub_item['icon'];?>"></i>
								<span class="nav-label"><?=$sub_item['title'];?></span>
							</a>
						</li>
					<? } ?>
					</ul>                    
				</li>
				<? } else { ?>
				<li class="dropdown<?=($page == $item['path']) ? ' active' : '';?>">
					<a href="<?=base_url() . $item['path'];?>">
						<i class="fa <?=$item['icon'];?>"></i>
						<span class="nav-label"><?=$item['title'];?></span>
					</a>
				</li>
				<? } ?>
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
