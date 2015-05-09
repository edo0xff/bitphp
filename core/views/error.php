<html>
<head>
	<meta charset="utf8">
	<title>¡Oops!</title>
	<style type="text/css">
		body, html { width: 100%; height: 100%; background-color: #f2f2f2; margin: 0; padding: 0px; font-family: sans-serif; }
		body { display: table; }
		a { text-decoration: none; color: gray; }
		.container { display: table-cell; vertical-align: middle; }
		.panel { border-radius: 6px; padding: 15px 20px; max-width: 800px; text-align: left; border: 2px solid rgb(255, 84, 84); }
		.sheet { color: gray; background-color: #fff; border-bottom-right-radius: 0; border-bottom-left-radius: 0; }
		.sheet .title { color:rgb(255, 84, 84); }
		.trace { color: #fff; background-color: rgb(255, 84, 84); font-family: monospace; font-size: 1em; border-top-left-radius: 0; border-top-right-radius: 0; }
		.header { position: fixed; left: 0px; top: 0px; color: gray; font-family: monospace; font-size: 1em; padding: 15px 20px; }
		.footer { position: fixed; right: 0px; bottom: 0px; color: gray; font-family: monospace; font-size: 1em; padding: 15px 20px; }
		pre { overflow-wrap: break-word; }
	</style>
</head>
<body>
	<div class="header"><b>B i t P H P</b> · M a r k - V</div>
	<div class="footer" align="right">
		<a href="http://bitphp.root404.com" target="__blank">bitphp.root404.com</a>
	</div>
	<div class="container" align="center">
		<br><br>
		<div class="panel sheet">
			<span class="title">¡ A l g o &nbsp; s a l i o &nbsp; m a l &nbsp; : 0 !</span>
			<br>
			<p> <?php echo $log['Description'] ?> <br> </p>
		</div>
		<div class="panel trace">
			<p><?php echo $log['Exception'] ?></p>
			<?php if( $log['PrintTrace'] ): ?>
				<h4>-- Stack traceback --</h4>
				<pre><?php print_r( $log['Trace'] ) ?></pre>
			<?php endif; ?>
		</div>
		<br><br>
	</div>
</body>
</html>