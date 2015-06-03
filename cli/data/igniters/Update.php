<?php namespace BitPHP\Cli\Igniters;

	use \BitPHP\Cli\StandardLibrary as Standard;
	use \BitPHP\Cli\FileWriter as File;
	use \BitPHP\Cli\Interfaces\Igniter;

	class Update implements Igniter {

		const SERVER_URI_BASE = 'http://localhost/api/bit/update';

		private static function check() {

			Standard::output('Checking for updates, please wait...','INFO');

			$info = @file_get_contents( self::SERVER_URI_BASE . '/check' );
			if( $info === false ) {
				Standard::output("Can't connect to server",'FAILURE');
				return false;
			}

			$info = json_decode($info,true)['result'];

			$last_update = file_get_contents('data/update.json');
			$last_update = json_decode($last_update,true);

			if( $last_update['current_release'] == $info['current_release'] ) {
				Standard::output('Without new updates, your bitphp already updated :D','FINAL');
				return false;
			}

			return $info;
		}

		public function retreive( $info ) {
			Standard::output('Files to download: ','INFO');
			foreach ($info['files_changed'] as $file) {
				Standard::output($file);
			}

			$files = @file_get_contents( self::SERVER_URI_BASE . '/retreive' );
			if( $files === false ) {
				Standard::output("Can't download files",'FAILURE');
				return false;
			}

			$files = json_decode($files,true)['files'];
			$count = count($files);

			for ( $i = 0; $i < $count; $i++ ) {
				$cheksum = md5($files[$i]['content']);
				if( $cheksum != $files[$i]['checksum'] ) {
					Standard::output('Corrupt file, retry update again','FAILURE');
					return;
				}

				File::write('../' . $files[$i]['name'],$files[$i]['content']);
				Standard::output($files[$i]['name'] . ' was updated!','SUCCESS');
			}

			File::write('data/update.json', json_encode($info,JSON_PRETTY_PRINT));
			Standard::output('Successful updated!','FINAL');
			Standard::output('Update info: ' . $info['more_info'], 'FINAL');
		}

		public static function init() {
			$info = self::check();
			if( $info === false ) {
				return;
			}

			$message  = "New update diaposable!\n";
			$message .= "Date: " . $info['date'] . "\n";
			$message .= "Files with changes: " .  $info['total_changes'] . "\n";
			$message .= "Description: " . $info['description'] . "\n";
			$message .= "Update now? (yes/no): ";
			
			Standard::output($message,'EMPASSIS',false);
			$input = Standard::input();

			if( $input == 'no' || $input == 'n' ) {
				return;
			}

			self::retreive($info);
		}
	}