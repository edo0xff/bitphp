<html>
<head>
	<meta charset="utf8">
	<title>¡Oops!</title>
	<style type="text/css">
		body, html { width: 100%; height: 100%; background-color: #f2f2f2; margin: 0; padding: 0px; font-family: sans-serif; }
		body { display: table; }
		a { text-decoration: none; color: gray; }
		.container { display: table-cell; vertical-align: middle; }
		.element {  max-width: 500px; color: gray; }
		.panel { border-radius: 6px; padding: 15px 20px; width: 100%; text-align: left; border: 2px solid rgb(255, 84, 84); }
		.sheet { color: gray; background-color: #fff; border-bottom-right-radius: 0; border-bottom-left-radius: 0; }
		.sheet .title { color:rgb(255, 84, 84); }
		.trace { color: #fff; background-color: rgb(255, 84, 84); font-family: monospace; font-size: 1em; border-top-left-radius: 0; border-top-right-radius: 0; }
		.header { position: fixed; left: 0px; top: 0px; color: gray; font-family: monospace; font-size: 1em; padding: 15px 20px; }
		.footer { position: fixed; right: 0px; bottom: 0px; color: gray; font-family: monospace; font-size: 1em; padding: 15px 20px; }
		.form-control { width: 100%; padding: 10px 15px; border-radius: 6px; margin-top: 3px; margin-bottom: 5px; border:solid 2px #aaa; outline: none; }
		.develop { color: rgb(40, 162, 215); }
		.form-control.develop { border-color: rgb(40, 162, 215); }
		.production { color: rgb(255, 84, 84); }
		.form-control.production { border-color: rgb(255, 84, 84); }
		.btn { padding: 15px 20px; background-color: #f2f2f2; color: gray; border: 2px solid gray; outline: none; }
		.btn:hover { background-color: #f5f5f5; cursor: pointer; }
	</style>
</head>
<body>
	<div class="header"><b>B i t P H P</b> · M a r k - V</div>
	<div class="footer" align="right">
		<a href="http://bitphp.root404.com" target="__blank">bitphp.root404.com</a>
	</div>
	<div class="container" align="center">
		<br><br><div class="element panel sheet">
			<p> <?php echo $_title ?> <br> </p>
		</div>
		<div class="element panel trace">
			<p>Puedes crear un archivo de configuracion aquí mismo, posteriormente descargarlo y colocarlo en la carpeta <b>/app/</b></p>
		</div>
		<div class="element">
			<br><br>
			<button class="btn" id="show-mvc-generator">Crear archivo de configuración</button>
		</div>
		<div class="element " align="left">
			<div class="generator" id="mvc_application" style="display:none;">
				<h4>Mvc-App Configuración general</h4>
				<label>Ambiente de la aplicación</label>
				<input class="form-control" type="text" id="enviroment" placeholder="develop/production">
				<label>Activar hmvc</label>
				<input class="form-control" type="text" id="hmvc" placeholder="true/false">
				<label>Aplicacion predeterminada</label>
				<input class="form-control" type="text" id="main_app" placeholder="foo (si se activa hmvc)">
				<label>Controlador predeterminado</label>
				<input class="form-control" type="text" id="main_controller" placeholder="home">
				<label>Acción predeterminada</label>
				<input class="form-control" type="text" id="main_action" placeholder="main">
				<label>Modulos auto-cargados</label>
				<input class="form-control" type="text" id="autoload_modules" placeholder="Template, Random, Foo, Foo2">
				<br><br>
				<b class="develop">Configuracion en ambiente de desarrollo (develop)</b><br><br>
				<label class="develop">Directorio base</label>
				<input class="form-control develop" type="text" id="dev_base_path" placeholder="/">
				<label class="develop">Debug (mostrar errores)</label>
				<input class="form-control develop" type="text" id="dev_debug" placeholder="true/false">
				<label class="develop">Host para la base de datos</label>
				<input class="form-control develop" type="text" id="dev_db_host" placeholder="localhost">
				<label class="develop">Usuario predeterminado para la base de datos</label>
				<input class="form-control develop" type="text" id="dev_db_user" placeholder="root">
				<label class="develop">Contraseña predeterminada para la base de datos</label>
				<input class="form-control develop" type="text" id="dev_db_pass" placeholder="your_pass">
				<label class="develop">Driver predeterminado para la base de datos</label>
				<input class="form-control develop" type="text" id="dev_db_driver" placeholder="mysql">
				<label class="develop">Charset determinado para la base de datos</label>
				<input class="form-control develop" type="text" id="dev_db_charset" placeholder="utf8">
				<br><br>
				<b class="production">Configuracion en ambiente de producción (production)</b><br><br>
				<label class="production">Directorio base</label>
				<input class="form-control production" type="text" id="pro_base_path" placeholder="/">
				<label class="production">Debug (mostrar errores)</label>
				<input class="form-control production" type="text" id="pro_debug" placeholder="true/false">
				<label class="production">Host para la base de datos</label>
				<input class="form-control production" type="text" id="pro_db_host" placeholder="localhost">
				<label class="production">Usuario predeterminado para la base de datos</label>
				<input class="form-control production" type="text" id="pro_db_user" placeholder="root">
				<label class="production">Contraseña predeterminada para la base de datos</label>
				<input class="form-control production" type="text" id="pro_db_pass" placeholder="your_pass">
				<label class="production">Driver predeterminado para la base de datos</label>
				<input class="form-control production" type="text" id="pro_db_driver" placeholder="mysql">
				<label class="production">Charset determinado para la base de datos</label>
				<input class="form-control production" type="text" id="pro_db_charset" placeholder="utf8">
				<br><br>
				<b>Alias para nombres de bases de datos</b><br><br>
				<label>Alias</label>
				<input class="form-control" type="text" id="db_alias" placeholder="Foo">
				<label>Nombre en desarrollo</label>
				<input class="form-control" type="text" id="db_dev_name" placeholder="dbfoo">
				<label>Nombre en producción</label>
				<input class="form-control" type="text" id="db_pro_name" placeholder="foo123234">
				<div id="alias-display"></div>
				<br><br>
				<button class="btn" id="add-alias">Agregar alias</button>
				<button class="btn" id="gen-mvc">Generar y descargar</button>
				<br><br>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var mvc_generator = document.getElementById('mvc_application');
		var btn_show_mvc = document.getElementById('show-mvc-generator');
		var btn_gen_mvc = document.getElementById('gen-mvc');
		var add_alias = document.getElementById('add-alias');
		var alias_display = document.getElementById('alias-display');
		var db_aliases = {};
		
		btn_show_mvc.onclick = function() {
			mvc_generator.setAttribute('style','display:block;');
		}

		add_alias.onclick = function() {
			var db_alias = document.getElementById('db_alias').value;
			var db_dev_name = document.getElementById('db_dev_name').value;
			var db_pro_name = document.getElementById('db_pro_name').value;

			if( db_alias == "" || db_dev_name == "" || db_pro_name == "" ) {
				alert("Todos los campos son obligatorios para agregar un alias");
				return 0;
			}

			db_aliases[db_alias] = { 
				develop: db_dev_name,
				production: db_pro_name
			};

			alias_display.innerHTML += "<b>" + db_alias + "</b>: pro->" + db_pro_name + " dev->" + db_dev_name + "<br>";
			alert("Agregado!");
		}

		var parseMvcConfig = function() {
			var enviroment = document.getElementById('enviroment');
			var hmvc = document.getElementById('hmvc');
			var main_app = document.getElementById('main_app');
			var main_controller = document.getElementById('main_controller');
			var main_action = document.getElementById('main_action');
			var autoload_modules = document.getElementById('autoload_modules');

			var dev_base_path = document.getElementById('dev_base_path');
			var dev_debug = document.getElementById('dev_debug');
			var dev_db_host = document.getElementById('dev_db_host');
			var dev_db_user = document.getElementById('dev_db_user');
			var dev_db_pass = document.getElementById('dev_db_pass');
			var dev_db_driver = document.getElementById('dev_db_driver');
			var dev_db_charset = document.getElementById('dev_db_charset');

			var pro_base_path = document.getElementById('pro_base_path');
			var pro_debug = document.getElementById('pro_debug');
			var pro_db_host = document.getElementById('pro_db_host');
			var pro_db_user = document.getElementById('pro_db_user');
			var pro_db_pass = document.getElementById('pro_db_pass');
			var pro_db_driver = document.getElementById('pro_db_driver');
			var pro_db_charset = document.getElementById('pro_db_charset');

			var config = {
				enviroment: enviroment.value != "" ? enviroment.value : "develop",
				hmvc: hmvc.value == "true" ? true : false,
				main_app: main_app.value,
				main_controller: main_controller.value != "" ? main_controller.value : "home",
				main_action: main_action.value != "" ? main_action.value : "main",
				autoload_modules: autoload_modules.value != "" ? autoload_modules.value.split(',') : [],
				develop: {
					base_path: dev_base_path.value != "" ? dev_base_path.value : "/",
					debug: dev_debug.value == "false" ? false : true,
					db_connection: {
						driver: dev_db_driver.value != "" ? dev_db_driver.value : "mysql",
						charset: dev_db_charset.value != "" ? dev_db_charset.value : "utf8",
						host: dev_db_host.value != "" ? dev_db_host.value : "localhost",
						user: dev_db_user.value != "" ? dev_db_user.value : "root",
						pass: dev_db_pass.value != "" ? dev_db_pass.value : ""
					}
				},
				production: {
					base_path: pro_base_path.value != "" ? pro_base_path.value : "/",
					debug: pro_debug.value == "true" ? true : false,
					db_connection: {
						driver: pro_db_driver.value != "" ? pro_db_driver.value : "mysql",
						charset: pro_db_charset.value != "" ? pro_db_charset.value : "utf8",
						host: pro_db_host.value != "" ? pro_db_host.value : "localhost",
						user: pro_db_user.value != "" ? pro_db_user.value : "root",
						pass: pro_db_pass.value != "" ? pro_db_pass.value : ""
					}
				},
				db_aliases: db_aliases
			}

			return config;
		}

		btn_gen_mvc.onclick = function() {
			download( parseMvcConfig() );
		}

		download = function( source ) {
			var source = JSON.stringify( source, null, 2 );
			var textFileAsBlob = new Blob([source], {type:'text/plain'});

			var downloadLink = document.createElement("a");
			downloadLink.download = "config.json";
			downloadLink.innerHTML = "Download File";

			if (window.webkitURL != null)
			{
				// Chrome allows the link to be clicked
				// without actually adding it to the DOM.
				downloadLink.href = window.webkitURL.createObjectURL(textFileAsBlob);
			}
				else
			{
				// Firefox requires the link to be added to the DOM
				// before it can be clicked.
				downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
				downloadLink.onclick = destroyClickedElement;
				downloadLink.style.display = "none";
				document.body.appendChild(downloadLink);
			}

			downloadLink.click();
		}
	</script>
</body>
</html>