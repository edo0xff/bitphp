<?php namespace BitPHP\Apps;

    require 'core/sys/socket_base/Client.php';
    require 'core/sys/socket_base/Router.php';
    #require 'core/sys/socket_base/Console.php';
    require 'cli/data/ConsoleColors.php';
    require 'cli/data/StandardLibrary.php';

    use \Closure;
    use \BitPHP\Socket\Client;
    #use \BitPHP\Socket\Console;
    use \BitPHP\Cli\StandardLibrary as Standard;

    class SocketServer {

        protected $address;
        protected $port;
        protected $eventListeners;
        protected $mainSocket;
        protected $clients = array();
        private $doLoop = true;

        public function __construct($address, $port) {
            set_time_limit(0);
            $this->eventListeners = array();
            $this->clients['sockets'] = array();
            $this->clients['objects'] = array();

            if(($this->mainSocket = @socket_create(AF_INET, SOCK_STREAM, 0)) === false) {
                Standard::output("No se pudo crear el socket: " . socket_strerror(socket_last_error()), 'FAILURE');
                exit;
            } else {
                Standard::output("Socket creado correctamente.");
            }

            if (@socket_bind($this->mainSocket, $address, $port) === false) {
                Standard::output("No se pudo enlazar: ".socket_strerror(socket_last_error($this->mainSocket)), 'FAILURE');
                exit;
            } else {
                Standard::output("Socket enlazado a $address:$port");
            }

            socket_getsockname($this->mainSocket, $address, $port);

            if((socket_set_option($this->mainSocket, SOL_SOCKET, SO_REUSEADDR, 1)) === false) {
                Standard::output("Error al crear el socket",'FAILURE');
                exit;
            }

            socket_listen($this->mainSocket);

            $this->clients['sockets'][] = $this->mainSocket;
            $this->clients['objects'][] = NULL; //mainSocket don't have object
            $this->address = $address;
            $this->port = $port;

            Standard::output("Esperando conexiones en $address:$port",'FINAL');
        }

        /*handshake new client.
        private function performHandshaking($receved_header, $client_conn, $host, $port) {

            $headers = array();
            $lines = preg_split("/\r\n/", $receved_header);
            foreach($lines as $line)
            {
                $line = chop($line);
                if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
                {
                    $headers[$matches[1]] = $matches[2];
                }
            }

            $secKey = $headers['Sec-WebSocket-Key'];
            $secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
            //hand shaking header
            $upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
            "Upgrade: websocket\r\n" .
            "Connection: Upgrade\r\n" .
            "WebSocket-Origin: $host\r\n" .
            "WebSocket-Location: ws://$host:$port/demo/shout.php\r\n".
            "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
            @socket_write($client_conn, $upgrade, strlen($upgrade));
        }*/

        private function triggerEvent($event, $param1 = null, $param2 = null) {
            if( !isset($this->eventListeners[$event]) ) {
                Standard::output("El evento $event no tiene un canditado de ejecucion.", 'INFO');
                return false;
            }

            $this->eventListeners[$event]($param1, $param2);
        }

        public function shutdown() {
            $this->doLoop = false;
        }

        public function disconnect(Client $client) {
            $this->triggerEvent('disconnect', $client);
            $client->close();
            $clientIndex = array_search($client->socket, $this->clients['sockets']);
            unset($this->clients['objects'][$clientIndex]);
            unset($this->clients['sockets'][$clientIndex]);
        }

        public function info() {
            $info = array();
            $info['clients'] = $this->clients['objects'];
            $found_socket = array_search($this->mainSocket, $this->clients['sockets']);
            unset($info['clients'][$found_socket]);
            return $info;
        }

        public function on($event, $callback) {
            if( !is_callable( $callback ) ) {
                return 0;
            }

            $this->eventListeners[ $event ] = Closure::bind( $callback, $this, get_class() );
        }

        public function send($message) {
            foreach ($this->clients['sockets'] as $socket) {
                @socket_write($socket, $message);
            }
        }

        public function sendFrom(Client $client, $message) {
            $sockets = $this->clients['sockets'];
            unset($sockets[ array_search($client->socket, $sockets) ]);
            foreach ($sockets as $socket) {
                @socket_write($socket, $message);
            }   
        }

        public function run() {

            #$console = new Console($this);
            #$console->start();

            do {
                $changed = $this->clients['sockets'];
                socket_select($changed, $write = NULL, $except= NULL, $tv_sec = 5);

                if (in_array($this->mainSocket, $changed)) {
                    $client = new Client(socket_accept($this->mainSocket)); //accpet new socket

                    $this->clients['objects'][] = $client;
                    $this->clients['sockets'][] = $client->socket; //add socket to client array

                    /*$header = socket_read($client->socket, 1024);
                    $this->performHandshaking($header, $client->socket, $host, $port);*/
        
                    $this->triggerEvent('connect', $client);
        
                    //make room for new socket
                    $found_socket = array_search($this->mainSocket, $changed);
                    unset($changed[$found_socket]);
                }

                foreach ($changed as $changedSocket) {
                    $buffer = @socket_read($changedSocket, 1024, PHP_NORMAL_READ);
                    $clientIndex = array_search($changedSocket, $this->clients['sockets']);

                    if( $buffer === false ) {
                        $this->triggerEvent('disconnect', $this->clients['objects'][$clientIndex]);
                        unset($this->clients['objects'][$clientIndex]);
                        unset($this->clients['sockets'][$clientIndex]);
                    } else {
                        $buffer = str_replace(["\r", "\n"], ['',''], $buffer);
                        if($buffer) {
                            $this->triggerEvent('read', $this->clients['objects'][$clientIndex], $buffer);
                        }
                    }
                }
            } while ($this->doLoop);

            Standard::output("Cerrando socket...");
            socket_close($this->mainSocket);
            Standard::output("Socket terminado.", 'FINAL');
        }
    }