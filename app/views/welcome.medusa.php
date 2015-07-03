<!DOCTYPE html>
<html>
<head>
	<title>¡Bienvenido!</title>
	<meta charset="utf8">
	:css bootstrap
	<style type="text/css">
		.jumbotron {
			color: #fff;
  			background-color: #9AA3FF;
		}

		.foo {
			color: #9AA3FF;	
		}
	</style>
</head>
<body>
	<div class="jumbotron">
		<div class="container">
			<div class="row">
				<h1>Yeah!</h1>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<h3>
				<span class="foo">#</span>
				Bitphp is running in this magical land, with unicorns and rainbowns!
			</h3>
			<h3>
				<span class="foo">#</span>
				Danger! This version is experimental, somethings can to explot D:
			</h3>
			<h3>
				<span class="foo">#</span>
				Bitphp global variable:
			</h3>
			<pre><?php echo json_encode($_BITPHP, JSON_PRETTY_PRINT) ?></pre>
		</div>
	</div>
</body>
</html>