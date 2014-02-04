<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?=$title;?> &middot; Admin Portal &middot; Staff Master</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="<?=base_url();?>assets/font-awesome/css/font-awesome.min.css">
	
	<!--[if IE 7]>
	<link rel="stylesheet" href="<?=base_url();?>assets/font-awesome/css/font-awesome-ie7.min.css">
	<![endif]-->
	
	<link href="<?=base_url();?>assets/css/bootstrap-fileupload.min.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/css/calendar.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/css/core.admin.css" rel="stylesheet" media="screen">
	<link href="<?=base_url();?>assets/prettyCheckable/prettyCheckable.css" rel="stylesheet" media="screen" type="text/css" />
	<?=$_styles;?>
	
	<script src="<?=base_url();?>assets/js/hogan.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.scrollTo.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.blockUI.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.json-2.4.min.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.confirm.js"></script>
	<script src="<?=base_url();?>assets/js/moment.js"></script>
	<script src="<?=base_url();?>assets/js/underscore-min.js"></script>
	
	
	
	<!-- datetimepicker (bootstrap 3)  -->
	<link href="<?=base_url();?>assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<script src="<?=base_url();?>assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
	
	<!-- x-editable (bootstrap 3) -->
	<link href="<?=base_url();?>assets/css/bootstrap-editable.css" rel="stylesheet">
	<script src="<?=base_url();?>assets/js/bootstrap-editable.min.js"></script>
	<script src="<?=base_url();?>assets/js/editable/time.js"></script>
	<link href="<?=base_url();?>assets/js/editable/break.css" rel="stylesheet">
	<script src="<?=base_url();?>assets/js/editable/breaks.js"></script>
	
	<!-- select -->
	<link href="<?=base_url();?>assets/css/bootstrap-select.min.css" rel="stylesheet">
	<script src="<?=base_url();?>assets/js/bootstrap-select.min.js"></script>
	
	<!-- typeaheadjs -->
	<link href="<?=base_url();?>assets/js/typeaheadjs/lib/typeahead.js-bootstrap.css" rel="stylesheet">
	<script src="<?=base_url();?>assets/js/typeaheadjs/lib/typeahead.js"></script>
	<script src="<?=base_url();?>assets/js/typeaheadjs/typeaheadjs.js"></script>
	
	
	<script src="<?=base_url();?>assets/js/bootstrap-fileupload.min.js"></script>
	<script src="<?=base_url();?>assets/js/calendar.js"></script>
	<script src="<?=base_url();?>assets/prettyCheckable/prettyCheckable.js" type="text/javascript" charset="utf-8"></script>
	<script> var base_url = '<?=base_url();?>'; </script>
	<script src="<?=base_url();?>assets/js/global.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
<? $user = $this->session->userdata('user_data'); ?>

<header>
    <div class="container-fluid">
       <div class="row profile-bar">
       		<div class="col-md-4 logo">
                <img src="<?=base_url();?>assets/img/core/staffmaster-logo.jpg" title="Staff Master Logo" alt="staffmaster-logo.jpg" />
            </div>
            <div class="col-md-8 profile-menu">
            	<div class="avatar pull">
                	<img src="<?=base_url();?>assets/img/dummy/default-avatar.png" title="User Avatar" alt="user-avatar.jpg" />
                </div>
            	<ul class="first-child">
                	<li><a title="Dashboard" href=""><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li><li class="li-seprator">|</li>
                    <li><a title="Logout" href=""><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
                    <li><a title="Message" href=""><i class="fa fa-comments"></i> <span>Message</span></a></li><li class="li-seprator">|</li>
                    <li><a title="Staff Account" href=""><i class="fa fa-user"></i> <span>Staff Account</span></a></li>
                </ul>
                <div class="message-badge">
                    <span class="badge danger">1</span>
                    <i class="fa fa-caret-right"></i>
                </div>
            </div>
       </div> 
       <?=$menu;?>
    </div>
</header>

	
	<!-- Begin page content -->
    <div class="container-fluid">
        <div class="row">
            <?=$content;?>
        </div>
    </div>


<div id="push"></div>


</body>
</html>