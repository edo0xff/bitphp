	<title>Oops!</title>
	<meta charset="utf8">
	<link rel="stylesheet" type="text/css" href="<?php echo \Bitphp\Core\Globals::get('base_uri') ?>/public/css/bootstrap.css">
	<style type="text/css">
		.jumbotron {
			color: #fff;
  			background-color: #9AA3FF;
		}

		.foo {
			color: #9AA3FF;	
		}

		.bit-err {
			position: absolute;
			width: 100%;
			height: 100%;
			top: 0;
			left: 0;
			background-color: #fff;
		}
	</style>
<div class="bit-err">
	<div class="jumbotron">
		<div class="container">
			<div class="row">
				<h1>Error!</h1>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<h3>
				<span class="foo">#</span>
				Hubo <?php echo count($errors) ?> errores en la aplicación.
			</h3>
			<?php foreach($errors as $error): ?>
				<h3>
					<span class="foo">#</span>
					<?php echo $error['message']  ?>.
				</h3>
				<pre>On <?php echo $error['file'] ?> at line <?php echo $error['line'] ?><br></pre>
			<?php endforeach; ?>
		</div>
	</div>
</div>