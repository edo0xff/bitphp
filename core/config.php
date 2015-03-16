<?php namespace BitPHP;

  /**
  *	Contains configuration parameters of BitPHP
  *	
  *	In this class are declared default database connection parameters
  *	(user, host, password), and some bitphp options, for example,
  *	indicate whether to display php's errors.
  *
  *	@author Eduardo B <ms7rbeta@gmail.com>
  *	@version stable 1.1.0
  *	@package Core
  *	@copyright 2014 Root404 Co.
  *	@website http://bitphp.root404.com <contacto@root404.com>
  *	@license GNU/GPLv3
  */
  class Config
  {

    const DEV = True;
    const ENABLE_HMVC = True;
    const ENABLE_PRO_MULTI_APP = False;
    const MAIN_CONTROLLER = 'home';
    const MAIN_APP = 'cpanel';
    const MAIN_ACTION = 'main';
    const ERR_VIEW = null;
    const NOT_FOUND_VIEW = null;
    const FORBIDDEN_VIEW = null;

    public static $AUTO_LOAD = array(
        'Template'
      , 'InputValidate'
    );

    public static $ON_DEV = array(
        'BASE_PATH' => '/'
      , 'PHP_ERRORS' => True
      , 'DB_HOST' => 'localhost'
      , 'DB_USER' => 'root'
      , 'DB_PASS' => ''
    );

    public static $ON_PRO = array(
        'APP_RUNNING' => 'cpanel'
      , 'BASE_PATH' => '/'
      , 'PHP_ERRORS' => False
      , 'DB_HOST' => 'localhost'
      , 'DB_USER' => 'u1723_rt404'
      , 'DB_PASS' => 'Papasconchile123'
    );

    /* ATENCION */
    #
    # Si no eres del equipo de desarrollo, por favor no toques nada de aquí para abajo,
    # la civilicacion como la conocemos depende de ello, gracias.

    public static function php_errors() { return self::DEV ? self::$ON_DEV['PHP_ERRORS'] : self::$ON_PRO['PHP_ERRORS']; }
    public static function db_host() { return self::DEV ? self::$ON_DEV['DB_HOST'] : self::$ON_PRO['DB_HOST']; }
    public static function db_user() { return self::DEV ? self::$ON_DEV['DB_USER'] : self::$ON_PRO['DB_USER']; }
    public static function db_pass() { return self::DEV ? self::$ON_DEV['DB_PASS'] : self::$ON_PRO['DB_PASS']; }
    public static function base_path() { return self::DEV ? self::$ON_DEV['BASE_PATH'] : self::$ON_PRO['BASE_PATH']; }
  } 
?>