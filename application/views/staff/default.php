<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<title><?=$title;?> &middot; Staff Portal &middot; Staff Master</title>
	
	
	<!-- Bootstrap core CSS -->
	<link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="<?=base_url();?>assets/font-awesome/css/font-awesome.min.css">
	
	<!--[if IE 7]>
	<link rel="stylesheet" href="<?=base_url();?>assets/font-awesome/css/font-awesome-ie7.min.css">
	<![endif]-->
	
	<!-- Core styles -->
	<link href="<?=base_url();?>assets/css/core.staff.css" rel="stylesheet" media="screen">
	<?=$_styles;?>
	
	
	<script src="<?=base_url();?>assets/js/jquery.min.js"></script>
	<script> var base_url = '<?=base_url();?>'; </script>
	<script src="<?=base_url();?>assets/js/core.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?=base_url();?>assets/js/core.staff.js" type="text/javascript" charset="utf-8"></script>
	
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

</head>
<body>

<header>
    <div class="container-fluid">
       <div class="row profile-bar">
       		<div class="col-md-12">
            	<div class="logo">
                	<img src="<?=base_url();?>assets/img/core/staffmaster-logo.jpg" title="Staff Master Logo" alt="staffmaster-logo.jpg" />
                </div>

                <div class="profile-menu">
                    <?=modules::run('account/menu');?>
                </div>
            </div>
       </div> 
       <?=$menu;?>
    </div>
</header>

	<div class="container-fluid">
        <div class="row">
            <?=$content;?>
        </div>
    </div><!-- /container -->

	<!-- Map Modal -->
	<div class="modal fade" id="modal_map" tabindex="-1" role="dialog" aria-hidden="true">
	</div><!-- /.modal -->
	<!-- Brief Modal -->
	<div class="modal fade" id="modal_brief" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	</div>


	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.confirm.js"></script>
</body>
</html>