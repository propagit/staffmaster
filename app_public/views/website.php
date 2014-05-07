<!DOCTYPE html>
<html>
  <head>
    <title>StaffBooks &middot; Work Force Management System</title>
    <meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?=base_url();?>assets/bootstrap-3.1.1-dist/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?=base_url();?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic|Raleway:400,300,500,600,700,800,900' rel='stylesheet' type='text/css'>
	
    <link href="<?=base_url();?>assets/website/css/public.css" rel="stylesheet" media="screen">
	
    <script> var base_url = '<?=base_url();?>'; </script>
	<script src="<?=base_url();?>assets/js/jquery.min.js"></script>
	<script src="<?=base_url();?>assets/bootstrap-3.1.1-dist/js/bootstrap.min.js"></script>
</head>
<body>
<div class="header-wrap">
	<div class="container">
		<div class="row" >
			<div class="col-md-6 logo-wrap">
				<a href="<?=base_url();?>"><img class="logo" src="<?=base_url();?>assets/website/img/logo_staffbooks.png" alt="logo"></a>
			</div>
			<div class="col-md-6">
				<ul class="nav nav-pills header-menu">
					<? $page = $this->uri->segment(1) ? $this->uri->segment(1) : 'home'; ?>
					<li<?=($page=='home') ? ' class="active"' : '';?>>
						<a href="<?=base_url();?>">HOME</a>                        
					</li>
					<li<?=($page=='tour') ? ' class="active"' : '';?>>
						<a href="<?=base_url();?>tour">TOUR</a>
					</li>
					<li<?=($page=='pricing') ? ' class="active"' : '';?>>
						<a href="<?=base_url();?>pricing">PRICING</a>
					</li>
					<li<?=($page=='resources') ? ' class="active"' : '';?>>
						<a href="<?=base_url();?>resources">RESOURCES</a>
					</li>
					<li<?=($page=='contact') ? ' class="active"' : '';?>>
						<a href="<?=base_url();?>contact">CONTACT</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="clear"></div>      
	</div>
</div>

<div class="clear"></div>


<?=$content;?>


<div id="footer-wrapper">
    <div class="container">
        <div class="wrap">
            <div class="row">
                <img src="<?=base_url();?>assets/website/img/logo_footer.png">
                <div class="footer-logo-text">WORKFORCE MANAGEMENT SYSTEM</div>
                <div class="row">
                	<div class="col-xs-9">
	                    <div class="left-side">
	                        <div class="footer-title"><i class="fa fa-briefcase right5"></i> COMPANY </div>
	                        <ul class="footer-jump">
	                            <li><a href="#" class="footer-link">STAFFMASTER - HOME</a></li>
	                            <li><a href="#" class="footer-link">SYSTEM TOUR</a></li>
	                            <li><a href="#" class="footer-link">PRICING</a></li>
	                            <li><a href="#" class="footer-link">RESOURCES</a></li>
	                            <li><a href="#" class="footer-link">CONTACT US</a></li>
	                        </ul>
	                    </div>
	                
	                    <div class="left-side">
	                        <div class="footer-title" style="width:300px;"><i class="fa fa-link right5"></i> SITE - QUICK LINK </div>
	                        <ul class="footer-jump" style="width:300px;">
	                            <li><a href="#" class="footer-link">STAFF INDUCTION & ON-BOARDING</a></li>
	                            <li><a href="#" class="footer-link">JOB ROSTER MANAGEMENT</a></li>
	                            <li><a href="#" class="footer-link">PAYROLL INTEGRATION (XERO - MYOB)</a></li>
	                            <li><a href="#" class="footer-link">TEMPORARY WORKFORCE MANAGEMENT</a></li>
	                            <li><a href="#" class="footer-link">STAFF COMPLIANCE & TRAINING</a></li>
	                        </ul>
	                    </div>
	                
	                    <div class="left-side">
	                        <div class="footer-title"><i class="fa fa-question-circle right5"></i> HELP </div>
	                        <ul class="footer-jump">
	                            <li><a href="#" class="footer-link">RESOURCE CENTRE</a></li>
	                            <li><a href="#" class="footer-link">SYSTEM STATUS</a></li>
	                            <li><a href="#" class="footer-link">STAFF SYSTEM CLOUD</a></li>                       
	                        </ul>
	                    </div>
	                
	                    <div class="left-side">
	                        <div class="footer-title"><i class="fa fa-wrench right5"></i> TOOLS </div>
	                        <ul class="footer-jump">
	                            <li><a href="#" class="footer-link">CUSTOMER API</a></li>
	                            <li><a href="#" class="footer-link">DEVELOPER API</a></li>
	                        </ul>
	                    </div>
	                </div>
	                
	                <div class="col-xs-3">
	                    <div class="left-side">
	                         <div class="footer-title">JOIN THE COMMUNITY </div>                        	
	                         <div class="footer-subtitle">RECEIVE NEWS & MEMBER DISCOUNTS</div>                        	                         
	                            <input type="text" class="input-txt bottom10" name="subscribe" id="subscribe">
	                         <div class="no-side">
	                             <div class="footer-title left-side"><i class="fa fa-twitter-square right5"></i> FOLLOW </div>                       
	                             <button type="button" class="btn btn-secondary right-side"> <i class="fa fa-envelope-o right5"></i> Join</button>
	                         </div>
	                    </div>
	                    <div class="clear"></div>
	                </div>
                </div>
                
                <div class="footer-copyright">&copy; StaffBooks - www.staffbooks.com</div>
            </div>
     	</div>
    </div>    
</div>

</body>
</html>
