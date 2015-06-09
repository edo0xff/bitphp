<?php namespace BitPHP\Socket;

    use \BitPHP\Socket\WebHandshake as Handshake;

    class Client {
        public $socket;
        public $ip;

        public function __construct($socket) {
            $this->socket = $socket;
            socket_getpeername($socket, $this->ip);
        }

        public function set($var, $val) {
            $this->$var = $val;
        }

        public function send($message) {
            $message = Handshake::mask($message);
            socket_write($this->socket, $message);
        }

        public function close() {
            socket_close($this->socket);
        }
    }