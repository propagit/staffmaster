<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">	
	<link rel="shortcut icon" href="<?=base_url();?>assets/img/favicon.ico">
	<title><?=$title;?> Timesheet</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- Bootstrap -->
	<link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="<?=base_url();?>assets/font-awesome/css/font-awesome.min.css">
	
	<!--[if IE 7]>
	<link rel="stylesheet" href="<?=base_url();?>assets/font-awesome/css/font-awesome-ie7.min.css">
	<![endif]-->
	
	<link href="<?=base_url();?>assets/css/bootstrap-fileupload.min.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/css/calendar.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/prettyCheckable/prettyCheckable.css" rel="stylesheet" media="screen" type="text/css" />
	
	<script src="<?=base_url();?>assets/js/hogan.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.sortable.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.form.js"></script> 
	<script src="<?=base_url();?>assets/js/jquery.scrollTo.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.blockUI.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.json-2.4.min.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.confirm.js"></script>
	<script src="<?=base_url();?>assets/js/moment.js"></script>
	<script src="<?=base_url();?>assets/js/underscore-min.js"></script>
	
	<!-- adminflare -->	
	<link href="<?=base_url();?>assets/css/adminflare.custom.css" rel="stylesheet" media="screen">
	<script src="<?=base_url();?>assets/js/adminflare.min.js"></script>
	
	<!-- highcharts -->
	<script src="<?=base_url();?>assets/highcharts/highcharts.js"></script>
	<script src="<?=base_url();?>assets/highcharts/modules/data.js"></script>
	
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
    
    <!-- select2 -->
	<link href="<?=base_url();?>assets/css/select2/select2.css" rel="stylesheet">
	<script src="<?=base_url();?>assets/js/select2.min.js"></script>
	
	<!-- typeaheadjs -->
	<link href="<?=base_url();?>assets/js/typeaheadjs/lib/typeahead.js-bootstrap.css" rel="stylesheet">
	<script src="<?=base_url();?>assets/js/typeaheadjs/lib/typeahead.js"></script>
	<script src="<?=base_url();?>assets/js/typeaheadjs/typeaheadjs.js"></script>
	

	
	<script src="<?=base_url();?>assets/js/bootstrap-fileupload.min.js"></script>
	<script src="<?=base_url();?>assets/js/calendar.js"></script>
	<script src="<?=base_url();?>assets/prettyCheckable/prettyCheckable.js" type="text/javascript" charset="utf-8"></script>
	<script> var base_url = '<?=base_url();?>'; </script>
	<script src="<?=base_url();?>assets/js/core.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=base_url();?>assets/css/core.staff.css" rel="stylesheet" media="screen">
    <?=$_styles;?>
	<script src="<?=base_url();?>assets/js/core.staff.js" type="text/javascript" charset="utf-8"></script>
    
    <!--flex slider2-->
    <link href="<?=base_url();?>assets/flex-slider/flexslider.css" rel="stylesheet" media="screen" type="text/css" />
	<script src="<?=base_url();?>assets/flex-slider/jquery.flexslider-min.js"></script>
    
    <!--magnific popup-->
    <link href="<?=base_url()?>assets/lightbox/magnific-popup.css" rel="stylesheet" media="screen">
    <script src="<?=base_url()?>assets/lightbox/jquery.magnific-popup.min.js"></script>
    
    <!--jrating-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/js/rating/jRating.jquery.css" media="screen" />
	<script type="text/javascript" src="<?=base_url()?>assets/js/rating/jRating.jquery.js"></script>
    
	<!-- Color Picker -->
    <link rel="stylesheet" media="screen" type="text/css" href="<?=base_url()?>assets/js/colorpicker/colorpicker.css" />  
	<script type="text/javascript" src="<?=base_url()?>assets/js/colorpicker/colorpicker.js"></script>
</head>
<body>

<header>
    <div class="container-fluid" id="sm-head-wrap">
       <div class="row profile-bar">
       		<div class="col-md-12">
            	<div class="logo">
                	<?=modules::run('setting/company_logo');?>
                </div>
            </div>
       </div> 
    </div>
</header>

	<div class="container-fluid" id="sm-body-wrap">
        <div class="row">
            <?=$content;?>
        </div>
    </div><!-- /container -->

<div id="sys-fixed-btns">
	<a href="http://resources.staffbooks.com/" target="_blank"><div class="btn btn-info sys-rt-btn"><i class="fa fa-info"></i></div></a>
    <a href="<?=base_url();?>logout"><div class="btn btn-info sys-rt-btn"><i class="fa fa-power-off"></i></div></a>
    <button class="btn btn-info sys-rt-btn custom-hidden go-to-top"><i class="fa fa-arrow-up"></i></button>
</div>

<div id="push"></div>

<!-- Large modal -->
<div class="modal fade bs-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"></div>

<!-- Normal modal -->
<div class="modal fade bs-modal-sml" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"></div>


<footer>
    <div id="sm-footer-wrap">
        <a target="_blank" href="http://www.staffbooks.com"><div class="footer-copy">&copy; StaffBooks - www.staffbooks.com</div></a>
        <!-- <button class="btn footer-go-to-top-btn custom-hidden go-to-top"><i class="fa fa-long-arrow-up footer-go-to-top-arrow"></i></button> -->
    </div>
</footer>
</body>
</html>