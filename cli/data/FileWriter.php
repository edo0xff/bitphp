<?php namespace BitPHP\CLi;

	class FileWriter {
		public static function write( $file, $content ) {
			$file = fopen( $file, 'w' );
			fwrite( $file, $content );
			fclose( $file );
		}
	}