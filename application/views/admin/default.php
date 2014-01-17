<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?=$title;?> &middot; Admin Portal</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="<?=base_url();?>assets/js/jquery.min.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap-fileupload.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.form.js"></script>
	<script src="<?=base_url();?>assets/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<!-- Bootstrap -->
	<link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="<?=base_url();?>assets/css/smoothness/jquery-ui-1.10.1.custom.min.css" rel="stylesheet" media="screen" />
	<link href="<?=base_url();?>assets/css/bootstrap-fileupload.min.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/css/admin.css" rel="stylesheet" media="screen">
		
	
</head>
<body>
<div id="wrap">
	<div id="header">
		<div class="container">
			<div id="logo"></div>
			<div id="welcome">
				<a class="btn btn-small btn-warning" href="<?=base_url();?>admin/logout">Logout</a><br />
				Logged in as: <b><? $admin = $this->session->userdata('admin_data'); echo $admin['name'];?> </b>
			</div>
		</div>
	</div>
	
	<!-- Begin page content -->
	<div class="page-content">
		<div class="container">
			<div class="shadow_title"></div>
			<div class="left_panel">
				<?=$menu;?>
			</div>
			<div class="main-content">    
				<?=$content;?>
			</div>
			<div class="clear"></div>
			<div class="shadow"></div>
		</div>
	</div>
</div>
<div id="clear"></div>
<div id="footer">
	<div class="container">
		<div class="shadow_reverse"></div>
		<p class="muted credit">
			<b>Module Repair Service Distributor Portal</b><br />
			Copyright &copy; System Architecture by <a href="#">Propagate</a> Web Development Services
		</p>		
	</div>
</div>



</body>
</html>