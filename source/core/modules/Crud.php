<?php

	use \BitPHP\Sys\DataBase;
	use \PDO;

	/**
  	*	@author Eduardo B <ms7rbeta@gmail.com>
  	*/
	class Crud extends DataBase {

		private $db = null;
		private $table_name = null;
		private $initialized_query = null;
		private $executed_query = null;
		public $result = null;
		public $query = null;
		public $stmt = null;
		public $error = null;

		public function db( $dbname ) {
			$this->db = self::driver( $dbname );
			return $this;
		}

		public function table( $table_name ) {
			
			if( !$this->db ) { 

				$m = 'Error al seleccionar la tabla.';
				$e = 'No puede ser usada antes de inicializar la base de datos <b>Crud::db</b>.';
				$bitphp->error->trace( $m, $e );
			}

			$this->table_name = $table_name;
			return $this;
		}

		/* Create */
		public function insert( $q ) {
			global $bitphp;

			if( !$this->table_name ) { 

				$m = 'Error al ejecutar sentencia <b>Crud::insert</b>.';
				$e = 'No puede ser usada antes de inicializar la tabla <b>Crud::table</b>.';
				$bitphp->error->trace( $m, $e );
			}

			$this->initialized_query = 'insert';

			$keys = array();
			$values = array();
			$i = 0;

			foreach ($q as $key => $value) {
				$keys[$i] = $key;
				$values[$i] = self::sanatize( $value );
				$i++;
			}

			$this->string =  'INSERT INTO ' . $this->table_name . '(' . implode( ',', $keys );
			$this->string .= ') VALUES (' . implode( ',', $values ) . ')';
			return $this;
		}

		/* Read */
		public function select( $q ) {
			global $bitphp;

			if( !$this->table_name ) { 

				$m = 'Error al ejecutar sentencia <b>Crud::select</b>.';
				$e = 'No puede ser usada antes de inicializar la tabla <b>Crud::table</b>.';
				$bitphp->error->trace( $m, $e );
			}

			$this->initialized_query = 'select';
			$this->string = "SELECT $q FROM $this->table_name";
			return $this;
		}

		/* Update */
		public function update( $q ) {
			global $bitphp;

			if( !$this->table_name ) { 

				$m = 'Error al ejecutar sentencia <b>Crud::update</b>.';
				$e = 'No puede ser usada antes de inicializar la tabla <b>Crud::table</b>.';
				$bitphp->error->trace( $m, $e );
			}

			$this->initialized_query = 'update';

			$values = array();
			$i = 0;

			foreach ($q as $key => $value) {
				$values[$i] = $key . '=' . self::sanatize( $value );
				$i++;
			}

			$this->string = "UPDATE $this->table_name SET " . implode( ',', $values);
			return $this;
		}

		/* Delete */
		public function delete() {
			global $bitphp;

			if( !$this->table_name ) { 

				$m = 'Error al ejecutar sentencia <b>Crud::delete</b>.';
				$e = 'No puede ser usada antes de inicializar la tabla <b>Crud::table</b>.';
				$bitphp->error->trace( $m, $e );
			}

			$this->initialized_query = 'delete';

			$this->string = "DELETE FROM $this->table_name";
			return $this;
		}

		public function where( $q ) {
			global $bitphp;

			if( !$this->string  ) {
				$m = 'Error al ejecutar sentencia <b>Crud::where</b>.';
				$e = 'Ninguna consulta a sido inicializada <b>Crud::select, Crud::update, Crud::delete</b>.';
				$bitphp->error->trace( $m, $e );
			}

			$this->string .= ' WHERE ';

			foreach ($q as $vars => $values) {

				$vars = explode(':', $vars);
				if ( count($vars) > 1 ) {
					$this->string .= " $vars[0] ";
					$vars = $vars[1];
				} else {
					$vars = $vars[0];
				}

				$vars_array = preg_split('/( AND | OR )/i', $vars);
   				$vars_len = count( $vars_array );
   				$var_values = array();

   				for( $i = 0; $i< $vars_len; $i++ ) {
	      			$var = trim( $vars_array[$i] );
      				$var_values[$i] = '( ' . str_replace( [':is:',':are:'], [$var,$var], $values) . ' )';
   				}

   				$vars = str_replace( $vars_array, $var_values, $vars);
   				$this->string .= "( $vars )";
			}

			return $this;
		}

		public function limit( $l, $r = null ) {
			global $bitphp;

			if( $this->initialized_query != 'select' ) {
				$m = 'Error al ejecutar sentencia <b>Crud::limit</b>.';
				$e = 'No se a inicializado ninguna consulta <b>Crud::select</b>.';
				$bitphp->error->trace( $m, $e );
			}

			$l_value = $r ? $l : 0;
			$r_value = $r ? $r : $l;

			$this->string .= " LIMIT $l_value,$r_value";
			return $this;
		}

		public function order( $key, $mode ) {
			global $bitphp;

			if( $this->initialized_query != 'select' ) {
				$m = 'Error al ejecutar sentencia <b>Crud::order</b>.';
				$e = 'No se a inicializado ninguna consulta <b>Crud::select</b>.';
				$bitphp->error->trace( $m, $e );
			}

			$this->string .= " ORDER BY $key " . ( $mode == 'up' ? 'ASC' : 'DESC' );
			return $this;
		}

		public function count() {
			global $bitphp;

			if( $this->executed_query != 'select' ) {
				$m = 'Error al enumerar los resultados de la consulta.';
				$e = 'Ninguna sentencia <b>Crud::select</b> ha sido ejecutada: <b>Crud::execute</b>.';
				$bitphp->error->trace( $m, $e );
			}

			return $this->error ? false : $this->stmt->rowCount();
		}

		public function first() {
			global $bitphp;

			if( $this->executed_query != 'select' ) {
				$m = 'Error al extraer el primer resultado de la consulta.';
				$e = 'Ninguna sentencia <b>Crud::select</b> ha sido ejecutada: <b>Crud::execute</b>.';
				$bitphp->error->trace( $m, $e );
			}

			return $this->error ? false : $this->result()[0];
		}

		public function last() {
			global $bitphp;

			if( $this->executed_query != 'select' ) {
				$m = 'Error al extraer el ultimo resultado de la consulta.';
				$e = 'Ninguna sentencia <b>Crud::select</b> ha sido ejecutada: <b>Crud::execute</b>.';
				$bitphp->error->trace( $m, $e );
			}

			return $this->error ? false : $this->result()[$this->stmt->rowCount() - 1];
		}

		public function result() {
			global $bitphp;

			if( $this->result === null ) {
				$m = 'Error al mostrar los resultados de la consulta.';
				$e = 'Ninguna sentencia ha sido ejecutada: <b>Crud::execute</b>.';
				$bitphp->error->trace( $m, $e );
			}

			return $this->result;
		}

		public function string() {
			return $this->string;
		}


		public function error() {
			return $this->error;
		}

		public function execute() {
			$this->stmt = $this->db->query( $this->string );
			$this->executed_query = $this->initialized_query;

			$this->error = $this->db->errorInfo()[2];

			if( $this->initialized_query == 'select' && !$this->error ) {
				$this->result = $this->stmt->fetchAll( PDO::FETCH_ASSOC );
			} else if ( !$this->error ) {
				$this->result = true;
			} else {
				$this->result = false;
			}

			return $this;
		}
	}
?>