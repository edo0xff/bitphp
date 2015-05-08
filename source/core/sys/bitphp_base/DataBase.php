<?php namespace BitPHP\Sys;

  use PDO;
  use PDOException;
  
  /**
  * @author Eduardo B <ms7rbeta@gmail.com>
  */
  class DataBase
  {
    /**
    *	Returns mysql driver, with default data base conection parameters (if not overwritten)
    *
    *	@param string $dbname data base's name
    *	@param array $p connection parameters
    *	@return object
    *	@todo modified to other controllers database and charset, mysql and utf8 by default
    */
    public function driver($dbname, $params = Null) {
      global $bitphp;

      $dbname = explode( ':', $dbname);
      if ( $dbname[0] == 'alias' ) {
        if( empty( $bitphp->getProperty('db_aliases')[ $dbname[1] ] ) ) {
          $m = "No se pudo cargar el nombre de base de datos del alias.";
          $e = 'No se a definido el alias <b>$alias</b>.';
          $bitphp->error->trace( $m, $e );
        }

        $alias = $bitphp->getProperty('db_aliases')[ $dbname[1] ];
        $dbname = $alias[ $bitphp->getProperty('enviroment') ];
      } else {
        $dbname = $dbname[0];
      }

      $params = $params ? $params : $bitphp->getEnviromentProperty('db_connection');

      try {
        return new PDO($params['driver'].':host='.$params['host'].';dbname='.$dbname.';charset='.$params['charset'],$params['user'],$params['pass']);
      } catch ( PDOException $e ) {
        $bitphp->error->trace(
            'Error al conectar con la base de datos. Verifica los parametros de conexion en el archivo de configuracion.'
          , $e->getMessage()
        );
      }
    }
  }