<?php namespace BitPHP\Socket;

    require_once 'cli/data/ConsoleColors.php';
    require_once 'cli/data/StandardLibrary.php';

    use \Thread;
    use \BitPHP\Cli\StandardLibrary as Standard;

    class Console extends Thread {
        private $server;

        public function __construct(&$server) {
            $this->server = $server;
        }

        public function run() {
            do {
                Standard::output('% >> ', null, false);
                $cmd = Standard::input();

                switch ($cmd) {
                    case 'exit':
                        $this->server->doLoop = false;
                        break 2;
                    
                    default:
                        Standard::output("[!]  commando $cmd invalido", 'FAILURE');
                        break;
                }
            } while(true);
        }
    }