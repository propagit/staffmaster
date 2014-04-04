<?
$page = $this->uri->segment(1) ? $this->uri->segment(1) : 'dashboard';
$menu = array(
	array('path' => '', 'icon' => 'dashboard', 'title' => 'Dashboard', 'sub' => array(
	)),
	array('path' => 'staff', 'icon' => 'user', 'title' => 'Your Profile', 'sub' => array(
	)),
	array('path' => 'work', 'icon' => 'thumbs-o-up', 'title' => 'Apply For Work', 'sub' => array(		
	)),
	array('path' => 'roster', 'icon' => 'calendar', 'title' => 'Your Roster', 'sub' => array(
	)),
	array('path' => 'timesheet', 'icon' => 'clock-o', 'title' => 'Time Sheets', 'sub' => array(		
	)),
	#array('path' => '#', 'icon' => 'book', 'title' => 'Training Centre', 'sub' => array(		
	#)),
	array('path' => '#', 'icon' => 'phone', 'title' => 'Support', 'sub' => array(		
	))
);
?>

<div id="nav-wrap">
	<div class="row desktop-visible">
    	<div class="col-md-12">
            <ul class="nav nav-pills">
            <? foreach($menu as $item) { ?>
                 <li class="dropdown<?=($page == $item['path']) ? ' active' : '';?>">
                    <a href="<?=base_url() . $item['path'];?>">
                      <i class="fa fa-<?=$item['icon'];?>"></i><span class="nav-label"><?=$item['title'];?></span>
                    </a>
                  </li>
            <? } ?>
            </ul>
        </div>
    </div>
    
    
    
    <!-- begin mob nav-->
    <div class="row desktop-hidden">
        <div class="navbar navbar-inverse">
            <div class="col-md-12">
                <span class="mob-menu-head">MENU</span>
                <button class="btn btn-navbar" data-target=".nav-collapse" data-toggle="collapse" type="button">
                   <i class="fa fa-align-justify"></i>
                </button>
            </div>
            <div class="nav-collapse collapse" id="nav-collapse-header" style="height: auto;">
                <ul class="nav">
                     <? foreach($menu as $item) { ?>
                         <li <?=($page == $item['path']) ? ' class="active"' : '';?> class="dropdown">
                            <a href="<?=base_url() . $item['path'];?>">
                              <i class="fa <?=$item['icon'];?>"></i><span class="nav-label"><?=$item['title'];?></span>
                            </a>
                          </li>
                    <? } ?>
                </ul>
            </div>

        </div>
    </div>
    <!-- end mob nv-->
    
    
</div>    


