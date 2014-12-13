<html>
	<head>
		<meta charset="utf-8">
		<title>@title</title>
	</head>
	<body>
		<h4>@nombre</h4>
		<hr>
		<p>
			<i> Con @edad años
			<? if(@edad >= 50): ?>
				eres un vejestorio :v</i>
			<? elseif(@edad >= 18): ?>
				no eres tan viejo :B</i>
			<? else: ?>
				aún eres joven :3</i>
			<? endif ?>
		</p>
	</body>
<html>