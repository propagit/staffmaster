<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$title;?> &middot; Staff Master</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url();?>assets/bootstrap-3.1.1-dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=base_url();?>assets/font-awesome/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="<?=base_url();?>assets/js/jquery.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.scrollTo.min.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
    <link href="<?=base_url();?>assets/website/css/public.css" rel="stylesheet">
  </head>

  <body>

    <div class="container">
      <div class="header">
        <br />
      </div>

      <div id="content">
        <?=$content;?>
      </div>

      

      <div class="footer">
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
