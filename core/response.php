<?php namespace BitPHP;
	
	use \BitPHP\Load;

	class Response 
	{
		public static function not_found() {
			global $_APP;
			http_response_code(404);
			
			if( Config::NOT_FOUND_VIEW ) {
				Load::view( Config::NOT_FOUND_VIEW );
			} else {
				echo '404 - Not Found';
			}

			exit;
		}

		public function forbidden() {
			global $_APP;
			http_response_code(403);
			
			if( Config::FORBIDDEN_VIEW ) {
				Load::view( Config::FORBIDDEN_VIEW );
			} else {
				echo '403 - Forbidden';
			}

			exit;
		}
	}
?>