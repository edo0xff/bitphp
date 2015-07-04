<?php 

	namespace Bitphp\Base\MvcServer;

	/**
	 *	Recibe como parametro en el contructor el arreglo 
	 *	de la url solicitada y en base a ella identifica 
	 *	el controlador, la accion, y los parametros
	 */
	class Route {

		private static function controller($uri) {
			if(!empty($uri[0])) {
				return $uri[0];
			}

			# main es el controlador por defecto
			return 'main';
		}

		private static function action($uri) {
			if(!empty($uri[1])) {
				return $uri[1];
			}

			# __index es la accion por defecto
			return '__index';
		}

		private static function uriParams($uri) {
			# /controlador/accion/parametro1/parametro2/etc
			# |                  | <- si solo existen estos 2
			#						  quiere decir qué no hay parametros :v
			if(2 < count($uri)) {
				$params = $uri;
				unset($params[0], $params[1]);
				return array_values($params);
			}

			# si no hay parametros retorna un array vacio
			return array();
		}

		public static function parse($request_uri) {
			$request_uri = explode('/', $request_uri);

			$result = [
				  'controller' => self::controller($request_uri)
				, 'action' => self::action($request_uri)
				, 'params' => self::uriParams($request_uri)
			];

			return $result;
		}
	}