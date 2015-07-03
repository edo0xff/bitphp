	<title>Oops!</title>
	<meta charset="utf8">
	<link rel="stylesheet" type="text/css" href="<?php echo $_BITPHP['BASE_URI'] ?>/public/css/bootstrap.css">
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
		}

		.bit-err-body {
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
	<div class="container bit-err-body">
		<div class="row">
			<h3>
				<span class="foo">#</span>
				Hubo <?php echo count($errors) ?> errores en la aplicación.
			</h3>
			<?php if(!$errors[0]['indentifier']): ?>
				<h3>
					<span class="foo">#</span>
					No se pudo registrar el error, verifica qué el fichero <i>/app/errors.log</i> tenga permisos de escritura.
				</h3>
			<?php endif; ?>
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