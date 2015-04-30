<?php namespace BitPHP\Sys;

  use Exception;

 /**
  * @author Eduardo B <ms7rbeta@gmail.com>
  */
  class Error
  {

    public $debug;

    public function __construct( $debug = true ) {

      if( !$debug ) {
        error_reporting(0);
        ini_set('display_errors', '0');
      }

      $this->debug = $debug;
    }

  /**
    *	Trace errors and terminate the app, normally only used by bitphp's core
    *
    *	@param string $d error's description, passed by reference
    *	@param string $e error's exception message, passed by reference
    *	@param boolean $trace indicates whether the error should be traced
    *	@return void
    */
    public function trace($d, $e, $print_trace = true) {
      $ex = new Exception();
      $trace = $ex->getTrace();

      $log = [
          "TimeStamp" => date('l jS \of F Y h:i:s A')
        , "Description" => $d
        , "Exception" => $e
        , "Trace" => $trace
        , "PrintTrace" => $print_trace
      ];

      if( $this->debug ){
          require('core/views/error.php');
      } else {
        $this->notFound();
      }

      $this->log( json_encode( $log, JSON_PRETTY_PRINT ) . '%/error/%' );
      exit;
    }

    public function log( $log ) {
      @error_log( $log, 3, 'core/log/errors.log' );
    }

    public function notFound() {
      global $_ROUTE;
      $_file = $_ROUTE['APP_PATH'] .'/views/errors/404.php';

      http_response_code(404);
      
      if( file_exists( $_file ) ) {
        require( $_file );
      } else {
        echo '404 - Not Found';
      }

      exit;
    }

    public function forbidden() {
      global $_ROUTE;
      $_file = $_ROUTE['APP_PATH'] .'/views/errors/403.php';

      http_response_code(403);
      
      if( file_exists( $_file ) ) {
        require( $_file );
      } else {
        echo '403 - Forbidden';
      }

      exit;
    }

    public function badRequest() {
      global $_ROUTE;
      $_file = $_ROUTE['APP_PATH'] .'/views/errors/400.php';

      http_response_code(400);
      
      if( file_exists( $_file ) ) {
        require( $_file );
      } else {
        echo '400 - Bad request';
      }

      exit;
    }

    public function unauthorized() {
      global $_ROUTE;
      $_file = $_ROUTE['APP_PATH'] .'/views/errors/401.php';

      http_response_code(401);
      
      if( file_exists( $_file ) ) {
        require( $_file );
      } else {
        echo '401 - Unauthorized';
      }

      exit;
    }
  }
?>