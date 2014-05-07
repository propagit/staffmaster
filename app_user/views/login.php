<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login &middot; <?=$title;?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="<?=base_url();?>assets/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=base_url();?>assets/font-awesome/css/font-awesome.min.css">
	<link href="<?=base_url();?>assets/css/login.css" rel="stylesheet">
    
    <?=$_styles;?>
</head>

<body>
<div class="container">
        <div class="form-signin login-row">
        	<div class="logo-wrap">
                <?=modules::run('setting/company_logo');?>
        	</div> 
            <form class="login-form" method="post" action="" >
                <input type="text" name="username"  class="form-control" placeholder="Email">
                <input type="password" name="password" class="form-control" placeholder="Password">
                <?=$msg_error;?>
                <div class="row">
                    <!--
					<div class="col-md-6">
                    	<a class="btn btn-block btn-social btn-facebook">
                            <i class="fa fa-facebook"></i> Sign in with Facebook
                        </a>
						<a class="btn btn-block btn-social btn-linkedin">
                            <i class="fa fa-linkedin"></i> Sign in with Linkedin
                        </a>
                    </div>
					-->
                    <div class="col-md-6">
                         <button class="btn btn-large btn-info pull login-btn" type="submit"><i class="fa fa-unlock-alt"></i> Sign In</button>
                         <a href="<?=base_url();?>forgot-password" class="forgot-password"><i class="fa fa-question-circle"></i> Forgot Your Details</a>
                    </div>
                </div>
            </form>
   		</div>
         
        <div class="login-row modern-browsers">
          	<img src="<?=base_url();?>assets/img/core/browsers-logos.png" alt="browsers-logos.png" title="Modern Browsers Logos"/>
            <p>
                StaffMaster works in the most up to date browsers.
                Please make sure you update your browser <i class="fa fa-smile-o"></i>
            </p>
        </div>
</div>

</body>
</html>
