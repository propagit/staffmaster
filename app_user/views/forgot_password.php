<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Forgot Password &middot; <?=$title;?></title>
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
            <div class="row">
            	<div class="col-md-12">
                	<p><br />To reset your password, enter your email in the text field below and hit <b>Reset</b> button. An email containing your new password will be sent your email.</p>
                </div>
            </div>
            <form class="login-form" method="post" action="" >
                <input type="text" name="username"  class="form-control" placeholder="Username">
                <?=$msg;?>
                <div class="row">
                    <div class="col-md-12">
                         <button class="btn btn-large btn-info pull login-btn" type="submit"><i class="fa fa-refresh"></i> Reset</button>
                         <a href="<?=base_url();?>login" class="forgot-password back-to-login"><i class="fa fa-arrow-circle-left"></i> Back to Login Page</a>
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
