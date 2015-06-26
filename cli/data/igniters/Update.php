<?php namespace BitPHP\Cli\Igniters;

	use \BitPHP\Cli\StandardLibrary as Standard;
	use \BitPHP\Cli\FileWriter as File;
	use \BitPHP\Cli\Interfaces\Igniter;
	use \BitPHP\Cli\DirHashing;

	class Update implements Igniter {

		const SERVER_URI_BASE = 'http://bitapi.root404.com/v2/update';

		private static function check() {

			Standard::output('Checking for updates, please wait...','INFO');

			$info = @file_get_contents( self::SERVER_URI_BASE . '/check' );
			if( $info === false ) {
				Standard::output("Can't connect to server",'FAILURE');
				return false;
			}

			return json_decode($info,true)['result'];
		}

		private function rmDeprecatedFiles($files) {
			foreach ($files as $file) {
				unlink($file);
				Standard::output("$file was removed.",'FAILURE');

				$dir = dirname($file);
				$rmdir = @rmdir($dir);
				if($rmdir) {
					Standard::output("$dir is empty, will be removed.",'FAILURE');
				}
					
				usleep(50000);
			}
		}

		private function retreive( $data ) {
			$url = self::SERVER_URI_BASE . '/retreive';
			$data = ['_files' => $data];

			// use key 'http' even if you send the request to https://...
			$options = array(
    			'http' => array(
        			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        			'method'  => 'POST',
        			'content' => http_build_query($data),
    			),
			);

			$context  = stream_context_create($options);
			$result  = file_get_contents($url, false, $context);
			$result  = json_decode($result, true)['result'];
			$corrupt = array();

			foreach ($result as $file => $data) {
				$checksum = md5($data['content']);
				if( $checksum != $data['checksum'] ) {
					Standard::output('Corrupt file ...','FAILURE');
					$corrupt[] = $file;
					continue;
				}

				File::write($file, $data['content']);
				Standard::output("$file was updated.",'SUCCESS');
				usleep(50000);
			}

			if(!empty($corrupt)) {
				Standard::output("Downloading again corrupt files ...", 'INFO');
				self::retreive($corrupt);
			}
		}

		public static function init() {
			$info = self::check();
			if( $info === false ) {
				return;
			}

			$coreHash = DirHashing::scan('../core');
			$cliHash  = DirHashing::scan('../cli');
			$list = array_merge($coreHash, $cliHash);

			$toUpdate = array();
			$newFiles = array();
			$toDelete = array();

			$count = 0;

			foreach ($info as $file) {
				$name = $file['file'];
				$hash = $file['hash'];

				if( isset( $list[$name] ) ) {
					if( $list[$name] != $hash ) {
						$toUpdate[] = $name;
						Standard::output("$name to be updated... [OLD]",'EMPASIS');
					} else {
						Standard::output("$name ... [OK]");
					}

					unset($list[$name]);

				} else {
					$newFiles[] = $name;
					Standard::output("$name to be created ... [NEW]",'INFO');
				}
				usleep(50000);
				$count++;
			}

			foreach ($list as $file => $hash) {
				Standard::output("$file is deprecated ... [DELETE]", 'FAILURE');
				$toDelete[] = $file;
				usleep(50000);
			}

			$countUpdate = count($toUpdate);
			$countNew    = count($newFiles);
			$countDelete = count($toDelete);

			$message = PHP_EOL;
			$message .= $countUpdate . ' files to UPDATE, ';
			$message .= $countNew . ' NEW files, ';
			$message .= $countDelete . ' files to DELETE.';
			Standard::output($message);

			if( !$countUpdate && !$countNew && !$countDelete ) {
				Standard::output('Nothing more to do.', 'FINAL');
				return;
			}

			Standard::output('Apply changes? (yes/no): ', null, false);
			$input = Standard::input();

			if( $input == 'no' || $input == 'n' ) {
				return;
			}

			if( $countDelete )
				self::rmDeprecatedFiles($toDelete);

			if( !$countUpdate && !$countNew ) {
				Standard::output('Nothing to download.', 'FINAL');
				return;
			}

			Standard::output('Downloading files, please wait...', 'INFO');
			self::retreive(array_merge($toUpdate, $newFiles));
		}
	}