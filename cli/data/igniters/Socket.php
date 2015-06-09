<?php namespace BitPHP\Cli\Igniters;

    use \BitPHP\Cli\StandardLibrary as Standard;
    use \BitPHP\Cli\FileWriter as File;
    use \BitPHP\Cli\Igniters\Config;
    use \BitPHP\Cli\Interfaces\Igniter;

    class Socket implements Igniter {
        
        private static function makeIndex() {
            $index = file_get_contents( 'data/templates/socket/server.txt' );
            Standard::output("Setting server.php...");
            
            File::write( '../server.php', $index );
            Standard::output("server.php was created.",'INFO');
        }

        public static function init() {
            self::makeIndex();

            Standard::output( "Socket server was created.", 'SUCCESS' );
            Standard::output( "You can run \"php server.php\" to listen for conecctions", 'FINAL' );
            Standard::output( "You can run \"telnet localhost 6000\" to connect by TCP", 'FINAL' );
        }
    }