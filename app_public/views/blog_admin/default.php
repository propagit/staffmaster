<!DOCTYPE html>
<html>
  <head>
    <title><?=$title;?> &middot; Admin Portal</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!--jquery-->
    <script src="<?=base_url();?>assets/js/jquery.min.js"></script>
    
    <!-- Bootstrap -->
	<link href="<?=base_url();?>assets/css/bootstrap.css" rel="stylesheet" media="screen">
    <script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.confirm.js"></script>
    
    <!--fontawesome-->
    <link rel="stylesheet" href="<?=base_url();?>assets/font-awesome/css/font-awesome.min.css">
    
    <!-- select -->
	<link href="<?=base_url();?>assets/css/bootstrap-select.min.css" rel="stylesheet">
	<script src="<?=base_url();?>assets/js/bootstrap-select.min.js"></script>
    
    <!--file upload-->
    <link href="<?=base_url();?>assets/css/bootstrap-fileupload.min.css" rel="stylesheet">
	<script src="<?=base_url();?>assets/js/bootstrap-fileupload.min.js"></script>
    
    <!-- datetimepicker (bootstrap 3)  -->
	<link href="<?=base_url();?>assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<script src="<?=base_url();?>assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    
    <!--blog backend css-->
    <link href="<?=base_url()?>assets/blog/css/backend.css" rel="stylesheet" media="screen">
	
    <script src="<?=base_url()?>assets/blog/js/helper.js"></script>
    <script src="<?=base_url()?>assets/ckeditor/ckeditor.js"></script>
    <script src="<?=base_url()?>assets/ckeditor/config.js"></script>
    <script src="<?=base_url()?>assets/ckeditor/styles.js"></script>
    <script src="<?=base_url()?>assets/ckfinder/ckfinder.js"></script>
    <script src="<?=base_url()?>assets/ckfinder/config.js"></script>
  </head>
  <body>
    <header class="navbar navbar-inverse bs-docs-nav" role="banner">
    	<div id="logout-btn"><a href="<?=base_url();?>admin/logout"><i class="fa fa-power-off"></i></a></div>
    	<div class="container">
	    	<div class="row">
	    		<div class="col-xs-12 col-sm-12">
	    			<div id="company-name">
                    	<img src="<?=base_url()?>assets/blog/img/admin-logo.png" />                        
                        <div style="margin-top:3px;">SM - ADMIN</div>
                    </div>	    			
	    		</div>

	    	</div>
	    	<div id="middle-gap">&nbsp;</div>
	    	<?=$menu;?>
    	</div>
    </header>
   	
    <div id="content">
    	<div class="container">
    	<?=$content?>
        </div>
    </div><!-- content -->
    
    <!--<footer>

    </footer>-->
    <!-- footer -->


  </body>
</html>
