<?php namespace BitPHP\Apps;

	require( 'core/sys/MicroServer.php' );

  use \DOMDocument;
  use \SimpleXMLElement;

  # Coded by Eduardo B <ms7rbeta@gmail.com>
	class Api extends MicroServer {

    public $routes = array();
    public $statusCode = 200;

    public function __construct() {
      parent::__construct();

      $this->method = $_SERVER['REQUEST_METHOD'];
      
      if( !(    $this->method == 'GET'
             || $this->method == 'POST'
             || $this->method == 'PUT'
             || $this->method == 'DELETE'
        ) )
      {
          $this->statusCode = 400;
          $this->response([
              'messaje' => "Bad method request $this->method"
          ]);
      }

      /* La entrada debe ser enviada en formato json */
      $request = json_decode( file_get_contents('php://input'), true );
      if( $request ) {
        $this->requestData = array_merge( $this->cleanData( $request ), $this->requestData );
      }

      $this->routes = [
          'GET' => array()
        , 'POST' => array()
        , 'PUT' => array()
        , 'DELETE' => array()
      ];
    }

    private function array_to_xml($student_info, &$xml_student_info) {
      foreach($student_info as $key => $value) {
        if(is_array( $value )) {
            if(!is_numeric( $key )){
                $subnode = $xml_student_info->addChild( $key );
                $this->array_to_xml( $value, $subnode );
            }
            else{
                $subnode = $xml_student_info->addChild( "item" );
                //$subnode->addAttribute( 'id',$key );
                $this->array_to_xml( $value, $subnode );
            }
        }
        else {
            $xml_student_info->addChild( $key,$value );
        }
      }
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
        $xml = new SimpleXMLElement("<?xml version=\"1.0\"?><root></root>");
        $this->array_to_xml( $data, $xml );
        echo $xml->asXML();
      } else {

        header( "HTTP/1.1 $this->statusCode $statusCodeString" );
        header( 'Content-Type: application/json;charset=utf-8' );
    	  $data = json_encode( $data, JSON_PRETTY_PRINT );
     	  echo $data;
      }

     	exit;
    }

    public function get( $route, $callback ) {

      $pattern = $this->createPattern( $route );
      $this->routes['GET'][$pattern] = $callback;
    }

    public function post( $route, $callback ) {

      $pattern = $this->createPattern( $route );
      $this->routes['POST'][$pattern] = $callback;
    }

    public function put( $route, $callback ) {

      $pattern = $this->createPattern( $route );
      $this->routes['PUT'][$pattern] = $callback;
    }

    public function delete( $route, $callback ) {

      $pattern = $this->createPattern( $route );
      $this->routes['DELETE'][$pattern] = $callback;
    }

    public function start() {
    	try {
    		$this->run( $this->routes[ $this->method ] );
    	} catch ( \Exception $e ) {
        $this->statusCode = 400;
    		$this->response([
				  'message' => 'Bad request'
				]);
    	}
    }
	}
?>