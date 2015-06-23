<?php

	require_once 'core/modules/DataBase.php';
	use \PDO;

	/**
  	*	@author Eduardo B <ms7rbeta@gmail.com>
  	*/
	class Crud extends DataBase {

		const ORDER_DESC = 'down';
		const ORDER_ASC  = 'up';

		private $db = null;
		private $table_name = null;
		private $initialized_query = null;
		private $executed_query = null;
		public $result = null;
		public $query = null;
		public $stmt = null;
		public $error = null;

		public function dataBase( $dbname ) {
			$this->db = self::driver( $dbname );
			return $this;
		}

		public function table( $table_name ) {
			
			if( !$this->db ) { 

				$message = 'Error al seleccionar la tabla.';
				$exception = 'No puede ser usada antes de inicializar la base de datos "Crud::db".';
				$bitphp->error->trace( $message, $exception );
			}

			$this->table_name = $table_name;
			return $this;
		}

		/* Create */
		public function insert( $q ) {
			global $bitphp;

			if( !$this->table_name ) { 

				$message = 'Error al ejecutar sentencia "Crud::insert".';
				$exception = 'No puede ser usada antes de inicializar la tabla "Crud::table".';
				$bitphp->error->trace( $message, $exception );
			}

			$this->initialized_query = 'insert';

			$keys = array();
			$values = array();
			$i = 0;

			foreach ($q as $key => $value) {
				$keys[$i] = $key;
				$values[$i] = "'$value'";
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

				$message = 'Error al ejecutar sentencia "Crud::select".';
				$exception = 'No puede ser usada antes de inicializar la tabla "Crud::table".';
				$bitphp->error->trace( $message, $exception );
			}

			$this->initialized_query = 'select';
			$this->string = "SELECT $q FROM $this->table_name";
			return $this;
		}

		/* Update */
		public function update( $q ) {
			global $bitphp;

			if( !$this->table_name ) { 

				$message = 'Error al ejecutar sentencia "Crud::update".';
				$exception = 'No puede ser usada antes de inicializar la tabla "Crud::table".';
				$bitphp->error->trace( $message, $exception );
			}

			$this->initialized_query = 'update';

			$values = array();
			$i = 0;

			foreach ($q as $key => $value) {
				$values[$i] = $key . "='$value'";
				$i++;
			}

			$this->string = "UPDATE $this->table_name SET " . implode( ',', $values);
			return $this;
		}

		/* Delete */
		public function delete() {
			global $bitphp;

			if( !$this->table_name ) { 

				$message = 'Error al ejecutar sentencia "Crud::delete".';
				$exception = 'No puede ser usada antes de inicializar la tabla "Crud::table".';
				$bitphp->error->trace( $message, $exception );
			}

			$this->initialized_query = 'delete';

			$this->string = "DELETE FROM $this->table_name";
			return $this;
		}

		/* where */

		private function exctractConditionOperator( $condition ) {
			$vars = explode(':', $condition);
			if ( count($vars) > 1 ) {
				$this->string .= " $vars[0] ";
				return $vars[1];
			} else {
				return $vars[0];
			}
		}

		private function conditionParse( $vars_array, $values ) {
			$vars_len = count( $vars_array );
			$vars_values = array();

   			for( $i = 0; $i < $vars_len; $i++ ) {
	      		$var = trim( $vars_array[$i] );
      			$vars_values[$i] = '( ' . str_replace( [':is:',':are:'], [$var,$var], $values) . ' )';
   			}

   			return $vars_values;
		}

		public function where( $q ) {
			global $bitphp;

			if( !$this->string  ) {
				$message = 'Error al ejecutar sentencia "Crud::where".';
				$exception = 'Ninguna consulta a sido inicializada "Crud::select, Crud::update, Crud::delete".';
				$bitphp->error->trace( $message, $exception );
			}

			$this->string .= ' WHERE ';

			foreach ($q as $vars => $values) {

				$vars = $this->exctractConditionOperator( $vars );
				$vars_array = $vars_array = preg_split('/( AND | OR )/i', $vars);
				$vars_values = $this->conditionParse( $vars_array, $values );
   				$vars = str_replace( $vars_array, $vars_values, $vars);
   				$this->string .= "( $vars )";
			}

			return $this;
		}

		public function limit( $l, $r = null ) {
			global $bitphp;

			if( $this->initialized_query != 'select' ) {
				$message = 'Error al ejecutar sentencia "Crud::limit".';
				$exception = 'No se a inicializado ninguna consulta "Crud::select".';
				$bitphp->error->trace( $message, $exception );
			}

			$l_value = $r ? $l : 0;
			$r_value = $r ? $r : $l;

			$this->string .= " LIMIT $l_value,$r_value";
			return $this;
		}

		public function order( $key, $mode ) {
			global $bitphp;

			if( $this->initialized_query != 'select' ) {
				$message = 'Error al ejecutar sentencia "Crud::order".';
				$exception = 'No se a inicializado ninguna consulta "Crud::select".';
				$bitphp->error->trace( $message, $exception );
			}

			$this->string .= " ORDER BY $key " . ( $mode == self::ORDER_ASC ? 'ASC' : 'DESC' );
			return $this;
		}

		public function result() {
			global $bitphp;

			if( $this->result === null ) {
				$message = 'Error al mostrar los resultados de la consulta.';
				$exception = 'Ninguna sentencia ha sido ejecutada: "Crud::execute".';
				$bitphp->error->trace( $message, $exception );
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