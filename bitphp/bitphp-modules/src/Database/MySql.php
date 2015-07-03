<?php namespace Bitphp\Modules\Database;

	use \PDO;
	use \Bitphp\Core\Config;

	/**
	 *	Proporciona una capa de abstracción para una conexión 
	 *	a basesde datos mysql a través de PDO
	 */	
	class MySql {
	
		private $pdo;
		private $statement;
		protected $host;
		protected $user;
		protected $pass;
		public $database;

		/**
		 *	Detecta si la base de datos seleccionada es un
		 *	alias, si es así trata de obtener el nombre real
		 *	de la base para dicho alias, si no existe manda error
		 *	y retorna nulo, si no es un alias retorna el valor original
		 */
		protected function realName($alias) {
			$is_alias = strpos($alias, 'alias.');
			if(false === $is_alias)
				return $alias;

			$name = Config::param("database.$alias");
			if(null === $name) {
				$message  = "El '$alias' para la base de datos no esta definido. ";
				$message .= 'Antes de poder usarlo definelo en la configuración';
				trigger_error($message);
				return null;
			}

			return $name;
		}

		public function __construct() {

			# Si no se encuentran en la configuración setea valores default
			$host = Config::param('database.host');
			if(null == $host)
				$host = 'localhost';

			$user = Config::param('database.user');
			if(null === $user)
				$user = 'root';

			$pass = Config::param('database.pass');
			if(null == $pass)
				$pass = '';

			$this->host = $host;
			$this->user = $user;
			$this->pass = $pass;
		}

		public function host($value) {
			$this->host = $value;
			return $this;
		}

		public function user($value) {
			$this->user = $value;
			return $this;
		}

		public function pass($value) {
			$this->pass = $value;
			return $this;
		}

		public function database($name) {
			# obtiene el nombre real, por si es un alias
			$name = $this->realName($name);
			$params = 'mysql:host='.$this->host.';dbname='.$name.';charset=utf8';
			$this->pdo = new PDO($params, $this->user, $this->pass);
			return $this;
		}

		public function query($query) {
			$this->statement = $this->pdo->query($query);
			return $this;
		}

		public function result() {
			return $this->statement->fetchAll(PDO::FETCH_ASSOC);
		}
	}