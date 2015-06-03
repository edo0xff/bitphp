<?php namespace BitPHP\Socket;

    #require_once 'cli/data/ConsoleColors.php';
    #require_once 'cli/data/StandardLibrary.php';

    use \BitPHP\Cli\StandardLibrary as Standard;

    class Router {

        public $server;

        public function __construct(&$server) {
            $this->server = $server;
            Standard::output("Iniciando ruteador de entrada...");
        }
        
        public function __call($called, array $args) {
            Standard::output("Ninguna accion definida para la ruta $called", 'FAILURE');
        }

        public function route(&$client, $buffer) {
            $decoded = json_decode($buffer, true);
            if(empty($decoded['action']) || empty($decoded['data'])) {
                Standard::output("Formato de datos invalido: $buffer");
                return false;
            }

            $this->$decoded['action']($client, $decoded['data']);
        }
    }