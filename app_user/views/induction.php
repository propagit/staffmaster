<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="<?=base_url();?>assets/img/favicon.ico">
    <title><?=$title;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="<?=base_url();?>assets/css/bootstrap.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="<?=base_url();?>assets/font-awesome/css/font-awesome.min.css">

    <!--[if IE 7]>
    <link rel="stylesheet" href="<?=base_url();?>assets/font-awesome/css/font-awesome-ie7.min.css">
    <![endif]-->

    <script src="<?=base_url();?>assets/js/jquery.min.js"></script>
    <script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
    <script src="<?=base_url();?>assets/js/moment.js"></script>

    <!-- select2 -->
    <link href="<?=base_url();?>assets/css/select2/select2.css" rel="stylesheet">
    <script src="<?=base_url();?>assets/js/select2.min.js"></script>


    <link href="<?=base_url();?>assets/css/core.admin.css" rel="stylesheet" media="screen">
    <script> var base_url = '<?=base_url();?>'; </script>
    <script src="<?=base_url();?>assets/js/core.js" type="text/javascript" charset="utf-8"></script>
    <?=$_styles;?>

    <!-- New stuff: SASS -->
    <link href="<?=base_url();?>css/app.min.css" rel="stylesheet" media="screen">


    <link href="<?=base_url();?>bower_components/angular-upload/src/directives/btnUpload.min.css" rel="stylesheet" media="screen">
    <link href="<?=base_url();?>bower_components/text-angular/src/textAngular.css" rel="stylesheet" media="screen">

    <link href="<?=base_url();?>bower_components/ng-sortable/dist/ng-sortable.min.css" rel="stylesheet" media="screen">


    <!-- New stuff: Angular -->

    <script src="<?=base_url();?>bower_components/angular/angular.min.js"></script>
    <script src="<?=base_url();?>bower_components/angular-upload/angular-upload.min.js"></script>
    <script src="<?=base_url();?>bower_components/text-angular/dist/textAngular.min.js"></script>
    <script src="<?=base_url();?>bower_components/text-angular/dist/textAngular-rangy.min.js"></script>
    <script src="<?=base_url();?>bower_components/text-angular/dist/textAngular-sanitize.min.js"></script>

    <script src="<?=base_url();?>bower_components/angular-multi-select/angular-multi-select.js"></script>
    <script src="<?=base_url();?>bower_components/ng-sortable/dist/ng-sortable.min.js"></script>
    <script src="<?=base_url();?>bower_components/angular-initial-value/dist/angular-initial-value.min.js"></script>



    <script src="<?=base_url();?>js/app.js"></script>
    <script src="<?=base_url();?>js/induction.js"></script>

</head>
<body ng-app="sb">

    <!-- Begin page content -->
    <div class="container-fluid" id="sm-body-wrap">
        <div class="row">
            <?=$content;?>
        </div>
    </div>


<div id="sys-fixed-btns">
    <a href="http://resources.staffbooks.com/" target="_blank"><div class="btn btn-info sys-rt-btn"><i class="fa fa-info"></i></div></a>
    <a href="<?=base_url();?>logout"><div class="btn btn-info sys-rt-btn"><i class="fa fa-power-off"></i></div></a>
    <button class="btn btn-info sys-rt-btn custom-hidden go-to-top"><i class="fa fa-arrow-up"></i></button>
</div>

<div id="push"></div>
</body>
</html>
