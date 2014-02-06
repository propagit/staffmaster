<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login &middot; <?=$title;?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="<?=base_url();?>assets/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=base_url();?>assets/font-awesome/css/font-awesome.min.css">
	<link href="<?=base_url();?>assets/css/login.css" rel="stylesheet">
</head>

<body>
<div class="container">
	<form method="post" class="form-signin" action="">
		<img src="<?=base_url();?>assets/img/logo.jpg" />
		<br /><br />
		<input type="text" name="username"  class="form-control" placeholder="Username">
		<input type="password" name="password" class="form-control" placeholder="Password">
		<?=$msg_error;?>
		<button class="btn btn-large btn-info" type="submit"><i class="fa fa-sign-in"></i> Login</button>
		
	</form>
</div>

</body>
</html>
