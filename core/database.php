<?php namespace BitPHP;

  use PDO;
  
  /**
  *	Provides methods for load easily PDO objects
  *
  *	Besides creating PDO objects, you can also filter queries that will
  *	be made to the database to clean possible characters that cause security holes.
  *
  *	@author Eduardo B <ms7rbeta@gmail.com>
  *	@version beta 1.1.0
  * @package Core
  *	@copyright 2014 Root404 Co.
  *	@website http://bitphp.root404.com <contacto@root404.com>
  *	@license GNU/GPLv3
  */
  class DataBase
  {
    /**
    *	Returns mysql driver, with default data base conection parameters (if not overwritten)
    *
    *	@param string $dbname data base's name
    *	@param array $p connection parameters
    *	@return object
    *	@example /var/www/docs/examples/DataBase_driver.php
    *	@todo modified to other controllers database and charset, mysql and utf8 by default
    */
    public static function driver($dbname, $p) {
      $host = empty($p['host']) ? $p['host'] : Config::db_host();
      $user = empty($p['user']) ? $p['user'] : Config::db_user();
      $pass = empty($p['pass']) ? $p['pass'] : Config::db_pass();

      return new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8',$user,$pass);
    }

    /**
    *	Cleaning a sql query potentially dangerous characters
    *
    *	@staticvar array $_warnings characters that should be treated
    *	@param string $string string to be cleaned
    *	@param boolean $remove Indicates whether to delete characters, or must be replaced by its html notation
    *	@return string
    *	@example /var/www/docs/examples/DataBase_sanatize.php
    */
    public static function sanatize($string, $remove = False) {
      $_warnings = ['\'','\\'];
      $_replaces = $remove ? ['',''] : ['&#146;','\\\\'];

      return str_replace($_warnings, $_replaces, $string);
    }

  }

?>