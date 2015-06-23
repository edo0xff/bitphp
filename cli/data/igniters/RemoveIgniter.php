<?php namespace BitPHP\Cli;

	use \BitPHP\Cli\StandardLibrary as Standard;

	class RemoveIgniter {

		private static function rmdirRecursive($dir) {
            if(!is_dir($dir))
                return;
            
    		foreach(scandir($dir) as $file) {
        		if ('.' === $file || '..' === $file) continue;
        		if (is_dir("$dir/$file")) self::rmdirRecursive("$dir/$file");
        		else unlink("$dir/$file");
    		}
    		rmdir($dir);
		}

		private static function fullMove( $source, $target ) {
    		if ( is_dir( $source ) ) 
    		{
        		if( !is_dir( $target ) ) { mkdir( $target ); }

        		$dir = dir( $source );
        		while ( FALSE !== ( $entry = $dir->read() ) ) 
        		{
            		if  ( 
            				   $entry == '.' 
            				|| $entry == '..'
            				|| $entry == '.htaccess'
            			) 
            		{
                		continue;
            		}
            		$Entry = $source . '/' . $entry; 
            		if ( is_dir( $Entry ) ) {
                		self::fullMove( $Entry, $target . '/' . $entry );
                		rmdir( $Entry );
                		continue;
            		}
		            rename( $Entry, $target . '/' . $entry );
    		    }
        		$dir->close();
    		}
    			else 
    		{
        		rename( $source, $target );
    		}
		}

		public static function restore() {
			if( !file_exists( 'bittrash/index.php' ) ) {
				Standard::output('Error: no backups in trash D:','FAILURE');
				return;
			}
			rename( 'bittrash/index.php', '../index.php' );
			self::fullMove('bittrash','../app');
			Standard::output('App successful restored :D','FINAL');
			self::rmdirRecursive('bittrash');
			mkdir('bittrash');
		}

		public static function init() {
			self::rmdirRecursive('bittrash');
			mkdir('bittrash');
			self::fullMove('../app','bittrash');
			@rename( '../index.php', 'bittrash/index.php' );
			Standard::output('App was remove','SUCCESS');
			Standard::output('You can restore the last remove typing: php dummy restore','FINAL');
		}
	}