<?php

	class DirListing {

		public function get_list($_path) {

			$result = array();
			$dir = opendir($_path);

			while( $element = readdir( $dir ) ) {
				if( $element != '.' && $element != '..' ) { array_push($result, $element); }
			}

			return $result;
		}
	}
?>