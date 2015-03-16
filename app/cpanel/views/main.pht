<html lang="es">
<head>
	<meta charset="utf-8">
	<title>BitPHP | Mark V</title>
	{css grid css}
	{css welcome css}
</head>
<body>
	<div class="container">
		<br>
		<div class="row">
			<div><span class="title">B i t P H P</span>M a r k &nbsp; V</div>
		</div>
		<div class="row">
			<hr>
			<div class="col-sm-4">
				<div class="panel">
					<h3>¡Bienvenido!</h3>
					<hr>
					<p align="justify">Arquitectura HMVC para mayor escalabilidad, núcleo más ligero, ahora puedes usar sólo lo que necesitas.</p>
				</div>
				<div class="panel blue-bottom">
					<h3>Apps</h3>
					<p>Actualmente se encuentran alojadas las siguientes aplicaciones <a href="#">( {{ count($apps) }} en total ):</a></p>
					<p>
						{each $apps as $app :}
							<a href="/{{ $app }}">{{  strtoupper( $app ) }}</a><br>
						{/each}
					</p>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="panel blue-bottom">
					<h3>Módulos auto-cargados</h3>
					<p>
						{each $modules as $module :}
							<a href="#">{{ $module }}</a><br>
						{/each}
					</p>
				</div>
				<div class="panel blue-bottom">
					<h3>Configuración general</h3>
					<p>
						ARCH_MODE: <a href="#">{{ $config['arch_mode'] }}</a><br>
						DEVELOP_MODE: <a href="#">{{ $config['dev_mode'] }}</a><br>
						MULTI_APP_ON_PRO_MODE: <a href="#">{{ $config['pro_multi_app'] }}</a><br>
						MAIN_CONTROLLER: <a href="#">{{ $config['main_controller'] }}</a><br>
						MAIN_ACTION: <a href="#">{{ $config['main_action'] }}</a><br>
						MAIN_APP: <a href="#">{{ $config['main_app'] }}</a><br>
						ERROR_VIEW: <a href="#">{{ $config['err_view'] }}</a><br>
						NOT_FOUND_VIEW: <a href="#">{{ $config['not_found_view'] }}</a><br>
						FORBIDDEN_VIEW: <a href="#">{{ $config['forbidden_view'] }}</a>
					</p>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="panel green-bottom">
					<h3>Configuración en modo desarrollo</h3>
					<p>
						APP_BASE_PATH: <a href="#">{{ $on_dev['base_path'] }}</a><br>
						SHOW_ERRORS: <a href="#">{{ $on_dev['php_errors'] }}</a><br>
						DATA_BASE_HOST: <a href="#">{{ $on_dev['db_host'] }}</a><br>
						DATA_BASE_USER: <a href="#">{{ $on_dev['db_user'] }}</a>
					</p>
				</div>
				<div class="panel red-bottom">
					<h3>Configuración en modo producción</h3>
					<p>
						APP_TO_RUN: <a href="#">{{ $on_pro['app_run'] }}</a><br>
						APP_BASE_PATH: <a href="#">{{ $on_pro['base_path'] }}</a><br>
						SHOW_ERRORS: <a href="#">{{ $on_pro['php_errors'] }}</a><br>
						DATA_BASE_HOST: <a href="#">{{ $on_pro['db_host'] }}</a><br>
						DATA_BASE_USER: <a href="#">{{ $on_pro['db_user'] }}</a>
					</p>
				</div>
			</div>
		</div>
	</div>
	<footer align="center"><a href="#">BitPHP</a> a free product by <a href="#">Root404 Co.</a></footer>
</body>
</html>