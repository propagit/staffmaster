<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login &middot; <?=$title;?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">   
    <link rel="stylesheet" href="<?=base_url()?>assets/backend/font-awesome/css/font-awesome.css">    
    <link href="<?=base_url()?>assets/backend/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">    
    <link href="<?=base_url()?>assets/backend/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" media="screen">    
    <link href="<?=base_url()?>assets/backend/bootstrap/css/bootstrap-select.css" rel="stylesheet" media="screen">
    <link href="<?=base_url()?>assets/backend/bootstrap/css/bootstrap-tree.css" rel="stylesheet" media="screen">
    <link href="<?=base_url()?>assets/backend/bootstrap/css/jasny-bootstrap.css" rel="stylesheet" media="screen">
    <link href="<?=base_url()?>assets/backend-assets/css/login.css" rel="stylesheet" media="screen">  
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200italic,300,300italic,400,400italic,600,600italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Changa+One:400' rel='stylesheet' type='text/css'>
    <script src="<?=base_url()?>assets/backend/js/jquery-1.9.1.min.js"></script>
	<script src="<?=base_url()?>assets/backend/bootstrap/js/bootstrap.js"></script>
    <script src="<?=base_url()?>assets/backend/bootstrap/js/bootstrap-select.js"></script>
    <script src="<?=base_url()?>assets/backend/bootstrap/js/bootstrap-tree.js"></script>
    <script src="<?=base_url()?>assets/backend/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?=base_url()?>assets/backend/bootstrap/js/jasny-bootstrap.js"></script>
</head>

<body>

<div class="container">
    <div class="row-fluid">
    <div class="span3">
        &nbsp;
    </div>
    <div class="span5">
        <div class="row-fluid" style="border:1px solid #e2e2e2;border-radius: 10px; margin-top: 33%">
            <div class="span12 login-box">
            	<div class="logo-box">
                	<img src="<?=base_url()?>assets/backend-assets/img/login/admin-logo.png" />
                    <h1>WAVE1 - ADMIN</h1>
                </div>
                <div class="break">&nbsp;</div>
                <form method="post" action="">
                <div class="row-fluid">
                    <div class="span3 login-label hidden-phone" >
                         USER NAME
                    </div>
                    
                    <div class="span7" >
                        <input required type="text" class="span12 login-txt-box" name="username" placeholder="Username" />
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span3 login-label hidden-phone">
                         PASSWORD
                    </div>
                    
                    <div class="span7">
                        <input required type="password" class="span12 login-txt-box" name="password" placeholder="Password" />
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4 pull-right">
                         <button class="btn login-btn span12" type="submit"><i class="fa fa-unlock-alt"></i>LOGIN</button>
                    </div>

                </div>
                </form>
                <?=$msg_error;?>
				<?php if($this->session->flashdata('error')) { ?>
                        <div class="alert alert-error login-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Error!</strong> Authorization failed: wrong combination of username/password
                        </div>
                <?php }?>
                
                <div class="row-fluid">
                   <div class="span12">
                   		<p class="copy-txt">Copyright &copy; <strong>FLARE</strong>RETAIL, all rights reserved</p>
                   </div>
                </div>
            </div>
        </div>
    </div>
    <div class="span3">
        &nbsp;
    </div>
    
    </div>
</div>

</body>
</html>