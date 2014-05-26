<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?=$title;?> &middot; Brief Viewer &middot; Staff Master</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="<?=base_url();?>assets/font-awesome/css/font-awesome.min.css">
	
	<!--[if IE 7]>
	<link rel="stylesheet" href="<?=base_url();?>assets/font-awesome/css/font-awesome-ie7.min.css">
	<![endif]-->
	
	<link href="<?=base_url();?>assets/css/bootstrap-fileupload.min.css" rel="stylesheet">
	
	<script src="<?=base_url();?>assets/js/hogan.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.scrollTo.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.json-2.4.min.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.confirm.js"></script>
	
     <!-- x-editable (bootstrap 3) -->
	<link href="<?=base_url();?>assets/css/bootstrap-editable.css" rel="stylesheet">
	<script src="<?=base_url();?>assets/js/bootstrap-editable.min.js"></script>
	<script src="<?=base_url();?>assets/js/editable/time.js"></script>
	<link href="<?=base_url();?>assets/js/editable/break.css" rel="stylesheet">
	<script src="<?=base_url();?>assets/js/editable/breaks.js"></script>	
    
    <!-- select2 -->
	<link href="<?=base_url();?>assets/css/select2/select2.css" rel="stylesheet">
	<script src="<?=base_url();?>assets/js/select2.min.js"></script>
	
	<script> var base_url = '<?=base_url();?>'; </script>
	<script src="<?=base_url();?>assets/js/core.js" type="text/javascript" charset="utf-8"></script>
    
    <link href="<?=base_url();?>assets/css/core.css" rel="stylesheet" media="screen">
	<link href="<?=base_url();?>assets/css/brief_viewer.css" rel="stylesheet" media="screen">
	<?=$_styles;?>

</head>
<body>
<header>
    <div class="container-fluid">
    	<div id="nav-wrap">
			<div class="row">
		    	<div class="col-md-12">
		            <ul class="nav nav-pills top-nav">
                    	<li class="dropdown"><a id="brief-shift-info"></a></li>
                    	<? if (!modules::run('auth/is_client')) { ?>
		            	<li><a id="btn-download-timesheet"><i class="fa fa-download"></i> Download Time sheet</a></li>
		            	<? } ?>
		            </ul>
		        </div>
		    </div>
		</div>  
    </div>
</header>

	
<!-- Begin page content -->
<div class="container-fluid">
    <div class="row">
        <?=$content;?>
    </div>
</div>


<div id="sys-fixed-btns">
	<button class="btn btn-info sys-rt-btn"><i class="fa fa-cogs"></i></button>
    <a href="<?=base_url();?>logout"><div class="btn btn-info sys-rt-btn"><i class="fa fa-power-off"></i></div></a>
    <button class="btn btn-info sys-rt-btn custom-hidden" id="go-to-top"><i class="fa fa-arrow-up"></i></button>
</div>

<div id="push"></div>

</body>
</html>