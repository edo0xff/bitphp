<?php namespace Bitphp\Modules\Database;

	use \Bitphp\Core\Config;

	class Oracle {
		protected $host;
		protected $user;
		protected $pass;
		protected $statement;
		public $database;

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

		public function user($value) {
			$this->user = $value;
			return $this;
		}

		public function pass($value) {
			$this->pass = $value;
			return $this;
		}

		public function host($host) {
			$this->host = $host;
		}

		public function database($name) {
			$host = $this->host . '/' . $name;
			$this->database = oci_connect($this->user, $this->pass, $host);
			if(!$this->database) {
				$exception = oci_error();
				trigger_error($exception);
			}
		}

		public function query($query) {
			$this->statement = oci_parse($this->database, $query);
			oci_execute($this->statement);
			
			if(!$this->statement) {
				$exception = oci_error();
				trigger_error($exception);	
			}

			return $this;
		}

		public function result() {
			return oci_fetch_array($this->statement, OCI_ASSOC+OCI_RETURN_NULLS);
		}
	}