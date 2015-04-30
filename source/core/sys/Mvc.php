<?php namespace BitPHP\Apps;
  
  use \BitPHP\Mvc\Load;
  use \BitPHP\Mvc\Route;

  class Mvc {

    public function run() {
			global $bitphp;      
      
      require('core/sys/bitphp_base/DataBase.php');
      require('core/sys/mvc_base/Input.php');
  		require('core/sys/mvc_base/Load.php');
  		require('core/sys/mvc_base/Route.php');
      require('core/sys/mvc_base/BitController.php');

  		$bitphp->route = Route::parse_route();
      
      $controller = $bitphp->route['APP_CONTROLLER'];
      $acction = $bitphp->route['APP_ACCTION'];

  		$bitphp->controller = Load::controller( $controller, $acction );
      
      Load::auto();
      $bitphp->controller->$acction();
		}
  }	
?>