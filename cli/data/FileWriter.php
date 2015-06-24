<?php namespace BitPHP\CLi;

	class FileWriter {
		public static function write( $file, $content ) {
            @mkdir(dirname($file), 0777, true);
			$file = fopen( $file, 'w' );
			fwrite( $file, $content );
			fclose( $file );
		}
	}