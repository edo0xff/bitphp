<?php

	use \BitPHP\Load;
	use \BitPHP\Config;

	class Home {

		public function __construct() {

			Load::module('DirListing');
		}

		public function main() {

			$config_params = [
				  'dev_mode' => Config::DEV ? 'ENABLED' : 'DISABLED'
				, 'arch_mode' => Config::ENABLE_HMVC ? 'HMVC' : 'MVC'
				, 'pro_multi_app' => Config::ENABLE_PRO_MULTI_APP ? 'ENABLED' : 'DISABLED' 
				, 'main_controller' => strtoupper( Config::MAIN_CONTROLLER )
				, 'main_action' => strtoupper( Config::MAIN_ACTION )
				, 'main_app' => strtoupper( Config::MAIN_APP )
				, 'err_view' => Config::ERR_VIEW ? strtoupper( Config::ERR_VIEW ) : 'NONE'
				, 'not_found_view' => Config::NOT_FOUND_VIEW ? strtoupper( Config::NOT_FOUND_VIEW ) : 'NONE'
				, 'forbidden_view' => Config::FORBIDDEN_VIEW ? strtoupper( Config::FORBIDDEN_VIEW ) : 'NONE'

			];

			$dev_config = [
				  'base_path' => Config::$ON_DEV['BASE_PATH']
				, 'php_errors' => Config::$ON_DEV['PHP_ERRORS'] ? 'ENABLED' : 'DISABLED'
				, 'db_host' => strtoupper( Config::$ON_DEV['DB_HOST'] )
				, 'db_user' => strtoupper( Config::$ON_DEV['DB_USER'] )
			];

			$pro_config = [
				  'app_run' => strtoupper( Config::$ON_PRO['APP_RUNNING'] )
				, 'base_path' => Config::$ON_PRO['BASE_PATH']
				, 'php_errors' => Config::$ON_PRO['PHP_ERRORS'] ? 'ENABLED' : 'DISABLED'
				, 'db_host' => strtoupper( Config::$ON_PRO['DB_HOST'] )
				, 'db_user' => strtoupper( Config::$ON_PRO['DB_USER'] )
			];

			$params = [
				  'apps' => DirListing::get_list('app')
				, 'modules' => Config::$AUTO_LOAD
				, 'config' => $config_params
				, 'on_dev' => $dev_config
				, 'on_pro' => $pro_config
			];

			Template::render('main', $params);
		}
	}
?>