<?php namespace BitPHP\Socket;

    use \BitPHP\Socket\WebHandshake as Handshake;

    class Client {
        public $socket;
        public $ip;

        public function __construct($socket) {
            $this->socket = $socket;
            socket_getpeername($socket, $this->ip);
        }

        public function __call( $methodName, array $args ) {
            if( isset( $this->newFunctions[ $methodName ] ) ) {
                return call_user_func_array( $this->newFunctions[ $methodName ], $args );
            }

            throw new RunTimeException("El metodo $methodName() no existe dentro de la instancia de la aplicacion.");
        }

        public function set( $item, $value ) {
            
            if( !is_callable( $value ) ) {
                $this->$item = $value;
                return 1;
            }

            $this->newFunctions[ $item ] = Closure::bind( $value, $this, get_class() );
        }

        public function send($message) {
            $message = Handshake::mask($message);
            socket_write($this->socket, $message);
        }

        public function close() {
            socket_close($this->socket);
        }
    }