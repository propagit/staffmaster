<?
$page = $this->uri->segment(1) ? $this->uri->segment(1) : 'dashboard';
$menu = array(
	array('path' => '', 'icon' => 'fa-dashboard', 'title' => 'Dashboard', 'sub' => array(
	)),
	array('path' => 'staff', 'icon' => 'fa-user', 'title' => 'Your Profile', 'sub' => array(
	)),
	array('path' => 'work', 'icon' => 'fa-thumbs-o-up', 'title' => 'Apply For Work', 'sub' => array(		
	)),
	array('path' => 'roster', 'icon' => 'fa-calendar', 'title' => 'Your Roster', 'sub' => array(
	)),
	array('path' => 'timesheet', 'icon' => 'fa-clock-o', 'title' => 'Time Sheets', 'sub' => array(		
	)),
	#array('path' => '#', 'icon' => 'book', 'title' => 'Training Centre', 'sub' => array(		
	#)),
	array('path' => '#', 'icon' => 'fa-phone', 'title' => 'Support', 'sub' => array(		
	))
);
?>

<div id="nav-wrap">
	<div class="row desktop-visible">
    	<div class="col-md-12"> 
            <ul class="nav nav-pills top-nav">
            <? foreach($menu as $item) { ?>
                 <li class="dropdown<?=($page == $item['path']) ? ' active' : '';?>">
                    <a href="<?=base_url() . $item['path'];?>">
                      <i class="fa <?=$item['icon'];?>"></i><span class="nav-label"><?=$item['title'];?></span>
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
                <button class="btn btn-navbar" data-target=".nav-collapse" data-toggle="collapse" type="button">
                   <i class="fa fa-align-justify"></i>
                </button>
                <span class="mob-menu-head">MENU <i class="fa fa-angle-right"></i></span>
            </div>
            <div class="nav-collapse collapse" id="nav-collapse-header" style="height: auto;">
                <ul class="nav top-nav">
                     <? foreach($menu as $item) { ?>
                         <li class="dropdown <?=($page == $item['path']) ? 'active' : '';?>">
                            <a class="dropdown-toggle" href="<?=base_url() . $item['path'];?>">
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


