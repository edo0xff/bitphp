<?php namespace BitPHP\MicroServer;

	class CleanData {

		public static function filter( $_something ) {
     		$data = null;

     		if( is_array( $_something ) ) {
       			$data = array();
       			foreach ($_something as $key => $value) {
         			$data[ $key ] = self::filter( $value );
	       		}
     		} else {
       			$data = trim( htmlentities( $_something, ENT_QUOTES ) );
     		}
	    	return $data;
   		}
	}