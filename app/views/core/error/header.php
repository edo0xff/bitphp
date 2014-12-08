<?php $path = \BitPHP\Config::BASE_PATH ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BitPHP - Error</title>
    <link href="<?php echo $path ?>app/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../app/resources/icons/favicon.png" />
    <script src="<?php echo $path ?>app/js/jquery.js"></script>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  <style>
    body,html{color:#eee;}
    .panel-body, .modal-dialog, span.close{ color:#000; }
  </style>
  </head>
  <div class="container">
	  <div class="row">
	    <div class="col-md-6 col-md-offset-3">
	      <br>
	      <div class="alert alert-danger" role="alert">
		<b>Error!</b> something went wrong :(
	      </div>
	      <div class="panel panel-default">
		<div class="panel-body">