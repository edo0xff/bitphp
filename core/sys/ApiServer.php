<?php namespace BitPHP\Apps;

	require 'core/sys/MicroServer.php';
  require 'core/sys/api_server_base/XmlArrayParser.php';
  require 'core/sys/api_server_base/Route.php';

  use \Exception;
  use \BitPHP\ApiServer\Route;
  use \BitPHP\ApiServer\XmlArrayParser as ArrayToXml;
  use \BitPHP\MicroServer\PatternParser as Pattern;
  use \BitPHP\MicroServer\CleanData;

  # Coded by Eduardo B <ms7rbeta@gmail.com>
	class ApiServer extends MicroServer {

    public $routes = array();
    public $statusCode = 200;

    public function __construct() {
      parent::__construct();

      try {
        $this->method = Route::getRequestMethod();
      } catch ( Exception $exception ) {
          $this->statusCode = 400;
          $this->response([
              'messaje' => "Bad method request $this->method"
          ]);
      }

      /* La entrada debe ser enviada en formato json */
      $request = json_decode( file_get_contents('php://input'), true );
      if( $request ) {
        $this->requestData = array_merge( CleanData::filter( $request ), $this->requestData );
      }

      $this->routes = [
          'GET' => array()
        , 'POST' => array()
        , 'PUT' => array()
        , 'DELETE' => array()
      ];
    }

   	public function getStatusMessage() {

   		$estado = [
   			200 => 'OK',  
   			201 => 'Created',  
   			202 => 'Accepted',  
   			204 => 'No Content',  
   			301 => 'Moved Permanently',  
   			302 => 'Found',  
   			303 => 'See Other',  
       	304 => 'Not Modified',  
       	400 => 'Bad Request',  
       	401 => 'Unauthorized',  
       	403 => 'Forbidden',  
       	404 => 'Not Found',  
       	405 => 'Method Not Allowed',  
       	500 => 'Internal Server Error'
    	];

    	if ( !isset( $estado[ $this->statusCode ] ) ) {
        
        $this->statusCode = 500;
    		$this->response([
    			'messaje' => "Bad status code $statusCode"
    		]);
    		exit;
    	}

    	return $estado[ $this->statusCode ];
    }

    public function response( $data ) {

    	$statusCodeString = $this->getStatusMessage();

      if( $this->request('format') == 'xml' ) {

        header( "HTTP/1.1 $this->statusCode $statusCodeString" );
        header( 'Content-Type: application/xml;charset=utf-8' );
        echo ArrayToXml::parse( $data );
      } else {

        header( "HTTP/1.1 $this->statusCode $statusCodeString" );
        header( 'Content-Type: application/json;charset=utf-8' );
    	  $data = json_encode( $data, JSON_PRETTY_PRINT );
     	  echo $data;
      }

     	exit;
    }

    public function get( $route, $callback ) {

      $pattern = Pattern::create( $route );
      $this->routes['GET'][$pattern] = $callback;
    }

    public function post( $route, $callback ) {

      $pattern = Pattern::create( $route );
      $this->routes['POST'][$pattern] = $callback;
    }

    public function put( $route, $callback ) {

      $pattern = Pattern::create( $route );
      $this->routes['PUT'][$pattern] = $callback;
    }

    public function delete( $route, $callback ) {

      $pattern = Pattern::create( $route );
      $this->routes['DELETE'][$pattern] = $callback;
    }

    public function run($routes = null) {
    	try {
    		parent::run( $this->routes[ $this->method ] );
    	} catch ( \Exception $e ) {
        $this->statusCode = 400;
    		$this->response([
				  'message' => 'Bad request'
				]);
    	}
    }
	}