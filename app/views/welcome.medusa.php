<!DOCTYPE html>
<html>
<head>
	<title>Yeah!</title>
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

		.sticker {
			max-width: 150px;
		}
	</style>
</head>
<body>
	<div class="jumbotron">
		<div class="container">
			<div class="row">
				<h1>All ready!</h1>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-sm-2" align="center">
				<img src="{{ :base }}/public/img/sticker.png" class="sticker">
			</div>
			<div class="col-md-8 col-md-offset-1">
				<h3>
					<span class="foo">#</span> &nbsp;
					Bitphp is running in this magical land, with unicorns and rainbowns!
				</h3>
				<h3>
					<span class="foo">#</span> &nbsp;
					Danger! This version is experimental, somethings can to exploit D:
				</h3>
				<h3>
					<span class="foo">#</span> &nbsp;
					Bitphp loaded config:
				</h3>
				<pre>{{ json_encode(\Bitphp\Core\Config::all(), JSON_PRETTY_PRINT) }}</pre>
			</div>
		</div>
	</div>
</body>
</html>