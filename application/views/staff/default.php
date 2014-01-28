<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?=$title;?> &middot; Staff Portal &middot; Staff Master</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="<?=base_url();?>assets/font-awesome/css/font-awesome.min.css">
	
	<!--[if IE 7]>
	<link rel="stylesheet" href="<?=base_url();?>assets/font-awesome/css/font-awesome-ie7.min.css">
	<![endif]-->
	
	<link href="<?=base_url();?>assets/css/bootstrap-fileupload.min.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/css/calendar.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/css/style.css" rel="stylesheet" media="screen">
	<link href="<?=base_url();?>assets/prettyCheckable/prettyCheckable.css" rel="stylesheet" media="screen" type="text/css" />
	<?=$_styles;?>
	
	<script src="<?=base_url();?>assets/js/jquery.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.scrollTo.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.blockUI.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.json-2.4.min.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.confirm.js"></script>
	<script src="<?=base_url();?>assets/js/moment.js"></script>
	<script src="<?=base_url();?>assets/js/underscore-min.js"></script>
	
	<!-- datetimepicker (bootstrap 3)  -->
	<link href="<?=base_url();?>assets/css/bootstrap-datetimepicker.css" rel="stylesheet">
	<script src="<?=base_url();?>assets/js/bootstrap-datetimepicker.js"></script>
	
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
<div id="wrap">
	<div id="header">
		<div class="container">
			<!--
<div class="pull-left">
				<div class="user_avatar">
					<i class="icon-user icon-3x"></i>
				</div>
			</div>
			<div class="pull-left">
				<h3><?=$user['first_name'] . ' ' . $user['last_name'];?></h3>
				<h4>Administrator &middot; Staff ID: <?=$user['user_id'];?></h4>
				<ul  class="top_nav">
					<li><a href="#"><i class="icon-pencil"></i> Edit Profile</a></li>
					<li><a href="#"><i class="icon-upload-alt"></i> Upload Profile Photo</a></li>
				</ul>
			</div>
-->
			<div class="pull-right">
				<ul class="top_nav">
					<li><a href="#"><i class="icon-dashboard"></i> Dashboard</a></li>
					<li><a href="#"><i class="icon-comments"></i> Messages</a></li>
					<li><a href="<?=base_url();?>account/admin"><i class="icon-user"></i> Admin Account</a></li>
					<li><a href="<?=base_url();?>logout"><i class="icon-signout"></i> Logout</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="menu">
		<div class="container">
			<?=$menu;?>
		</div>
	</div>
	
	<!--
<div class="page-title">
		<div class="shadow_title"></div>
		<div class="container">
			<h2><?=$title?></h2>
		</div>		
	</div>
-->
	
	<!-- Begin page content -->
	<div class="page-content">
		<div class="container">
			<!-- <div class="shadow_title"></div> -->
			<div class="content-inner">
				<?=$content;?>
			</div>
		</div>
	</div>
</div>
<div id="push"></div>
<!--
<div id="footer">
	<div class="container">
		<ul class="pull-right">
			<li><a href="<?=base_url();?>term-of-use">Term of Use</a></li>
			<li><a href="<?=base_url();?>privacy-policy">Privacy Policy</a></li>
			<li><a href="<?=base_url();?>terms-conditions">Terms & Conditions</a></li>
			<li><a href="<?=base_url();?>logout">Logout</a></li>
		</ul>
		<p class="credit">Copyright &copy; <a href="#">Propagate</a> World Wide Pty Ltd</p>
		
	</div>
</div>
-->

</body>
</html>