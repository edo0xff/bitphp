<?php namespace BitPHP\MicroServer;

	class PatternParser {
		public static function create( $route ) {
			$search = [
				  '/'
				, ':word'
				, ':number'
				, ':any'
			];
			$replace = [
				  '\/'
				, '(\w+)'
				, '(\d+)'
				, '(.*)'
			];
			return '/^' . str_replace( $search, $replace, $route ) . '$/';
		}
	}