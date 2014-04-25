<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?=$heading;?> &middot; Staff Master</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
	
	<!--[if IE 7]>
	<link rel="stylesheet" href="assets/font-awesome/css/font-awesome-ie7.min.css">
	<![endif]-->
	
	
    <link href="assets/css/error.css" rel="stylesheet" media="screen">

</head>
<body>
<header>
    <div class="container-fluid">
    	<div id="nav-wrap">
			<div class="row desktop-visible">
		    	<div class="col-md-12">
		            <?=$heading;?>
		        </div>
		    </div>
		</div>  
    </div>
</header>

	
<!-- Begin page content -->
<div class="container-fluid">
    <div class="row">
    	<div class="col-md-12">
			<div class="box">
				<h2><i class="fa fa-frown-o"></i> &nbsp; Oh no!<br />There appears to have been a malfunction</h2>
				<br />
				<?=$message;?>
				<br />
				<a class="btn btn-core btn-lg" href="/"><i class="fa fa-dashboard"></i> Go To Dashboard</a>
			</div>
    	</div>
    </div>
</div>


<div id="push"></div>

</body>
</html>