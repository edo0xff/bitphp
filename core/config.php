<?php
  namespace BitPHP;
  /**
  *	Contains configuration parameters of BitPHP
  *	
  *	In this class are declared default database connection parameters
  *	(user, host, password), and some bitphp options, for example,
  *	indicate whether to display php's errors.
  *
  *	@author Eduardo B <ms7rbeta@gmail.com>
  *	@version stable 1.1.0
  *	@package BitPHPCore
  *	@copyright 2014 Root404 Co.
  *	@website http://bitphp.root404.com <contacto@root404.com>
  *	@license GNU/GPLv3
  */
  class Config
  {
    /**
    *	Base Path, if framework work in root folder then value is "/"
    *
    *	eg.1 "/subfolder/"
    *	eg.2 "/subfolder/other_subforlder/"
    */
    const BASE_PATH = "/";

    /**
    *	Controller to be loaded by default (index)
    */
    const DEFAULT_CONTROLLER = 'home';
    /**
    *	Indicates whether to display php errors
    */
    const DISPLAY_PHP_ERRORS = True;

    /**
    *	Default host for PDO object
    */
    const DEFAULT_HOST    = 'localhost';
    /**
    *	Default user for PDO object
    */
    const DEFAULT_USER    = 'root';
    /**
    *	Default pass for PDO object
    */
    const DEFAULT_PASS    = '';

    # ADMIN OPTIONS
    /**
    *	Enable if you want that user can report issues.
    *	the issue's report to be encryted.
    */
    const CRYPTED_ISSUES_REPORT = True;
    /**
    *	CryptKey for error messages
    */
    const CRYPT_KEY = 'Default_123';
    /**
    * Admin email
    */
    const ADMIN_EMAIL = 'admin@yourdomain.com';
  }
?>