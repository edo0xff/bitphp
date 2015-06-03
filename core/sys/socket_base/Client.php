<?php namespace BitPHP\Socket;

    class Client {
        public $socket;
        public $ip;

        public function __construct($socket) {
            $this->socket = $socket;
            socket_getpeername($socket, $this->ip);
        }

        public function send($message) {
            socket_write($this->socket, $message);
        }

        public function close() {
            socket_close($this->socket);
        }
    }