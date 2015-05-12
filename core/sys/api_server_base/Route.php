<?php namespace BitPHP\ApiServer;

	class Route {
		public function getRequestMethod() {
			$method = $_SERVER['REQUEST_METHOD'];
      
      		if( !(  $method == 'GET'
		            || $method == 'POST'
             		|| $method == 'PUT'
             		|| $method == 'DELETE'
        		) )
      		{
          		throw new Exception("Invalid request method", 1);
      		}

      		return $method;
		}
	}