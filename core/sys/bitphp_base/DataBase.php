<?php namespace BitPHP\Sys;

  use PDO;
  use PDOException;
  
  /**
  * @author Eduardo B <ms7rbeta@gmail.com>
  */
  class DataBase {

    protected function parseAlias( $dbname ) {
      global $bitphp;

      $dbname = explode( ':', $dbname);
      if ( $dbname[0] == 'alias' )  {

        if( empty( $bitphp->config->property('db_aliases')[ $dbname[1] ] ) ) {

          $message   = "No se pudo cargar el nombre de base de datos del alias.";
          $exception = "No se a definido el alias \"$dbname[1]\".";
          $bitphp->error->trace( $message, $exception );
        }

        $alias = $bitphp->config->property('db_aliases')[ $dbname[1] ];
        $dbname = $alias[ $bitphp->config->property('enviroment') ];
      } else {
        $dbname = $dbname[0];
      }

      return $dbname;
    }

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

      $dbname = self::parseAlias( $dbname );
      $params = $params ? $params : $bitphp->config->environmentProperty('db_connection');

      try {
        $pdo = $params['driver'].':host='.$params['host'].';dbname='.$dbname.';charset='.$params['charset'];
        return new PDO( $pdo ,$params['user'],$params['pass']);
      } catch ( PDOException $exception ) {
        $message = 'Error al conectar con la base de datos. Verifica los parametros de conexion en el archivo de configuracion.';
        $bitphp->error->trace( $message, $exception->getMessage() );
      }
    }
  }