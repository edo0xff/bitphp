<?php $path = \BitPHP\Config::BASE_PATH ?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BitPHP - Welcome!</title>
    <link href="<?php echo $path ?>app/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $path ?>app/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo $path ?>app/css/prism.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo $path ?>app/resources/icons/favicon.png" />
    <script src="<?php echo $path ?>app/js/jquery.js"></script>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  <style>
    body,html{color:#eee;}
    .panel-body, .modal-dialog, .btn-close{color:#000;}
    .btn-close:hover{color:#000;}
  </style>
  </head>
  <body>
  	<div class="container">
	  <div class="row">
	    <div class="col-md-6 col-md-offset-3">
	      <br>
	      <div class="alert alert-success" role="alert">
		<b>Yeah!</b> BitPHP 2.0 is running with
		<b>PHP <?php echo phpversion() ?></b>
		and <b>ZendEngine <?php echo zend_version() ?>.</b>
	      </div>
	      <div class="panel panel-default">
		<div class="panel-body">
		  <?php \BitPHP\Load::view('default/first_steeps'); ?>
		</div>
	      </div>
	      <div class="panel panel-default">
		<div class="panel-body" align="center">
		  <a href="http://bitphp.root404.com" target="_blank">BitPHP</a> a free product by
		  <a href="http://root404.com" target="_blank">Root404 Co.</a>
		</div>
	      </div>
	    </div>
	  </div>
	  <?php \BitPHP\Load::view('default/examples'); ?>
	</div>
      </div>
    <!-- jQuery and bootstrap -->
    <script src="<?php echo $path ?>app/js/bootstrap.min.js"></script>
    <!--BACKSTRETCH-->
    <script src="<?php echo $path ?>app/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch(
 	  [
	    "<?php echo $path ?>app/resources/images/default-01.jpg",
	    "<?php echo $path ?>app/resources/images/default-02.jpg",
	    "<?php echo $path ?>app/resources/images/default-03.jpg",
	    "<?php echo $path ?>app/resources/images/default-04.jpg"
	  ],
	  {duration: 30000, fade: 1000});
    </script>
    <!--Prims js, for code highlight-->
    <script src="<?php echo $path ?>app/js/prism.min.js"></script>
  </body>
</html>