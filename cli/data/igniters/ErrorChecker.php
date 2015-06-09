<?php namespace BitPHP\Cli\Igniters;

    use \BitPHP\Cli\StandardLibrary as Standard;
    use \BitPHP\Cli\FileWriter as File;
    use \BitPHP\Cli\Igniters\Config;
    use \BitPHP\Cli\Interfaces\Igniter;

    class ErrorChecker implements Igniter {
        public static function init() { return 0; }

        private function readErrorLog() {
            $error_log = file_get_contents('../core/log/errors.log');

            if($error_log === false) {
                Standard::output("Can't read error log file.",'FAILURE');
                exit;
            }

            return explode("\n", $error_log);
        }

        public function dump() {
            Standard::output('Dumping error log file...');
            File::write('../core/log/errors.log','');
            Standard::output('Error log is empty.', 'FINAL');
        }

        public function all() {
            $errors = self::readErrorLog();
            $count = 0;
            foreach ($errors as $error) {
                $error = json_decode($error, true);
                if(!empty($error['id'])) {
                    $info  = 'Error ID: ' . $error['id'] . PHP_EOL;
                    $info .= 'Date: ' . $error['timestamp'] . PHP_EOL;
                    $info .= 'Description: ' . $error['description'] . PHP_EOL;
                    Standard::output($info, 'INFO');
                    $count++;
                }
            }

            Standard::output($count . ' errors.', 'FINAL');
        }

        public function check($errorId) {
            $errors = self::readErrorLog();
            $flag = false;
            foreach ($errors as $error) {
                $error = json_decode($error, true);
                if($error['id'] == $errorId) {
                    $info  = PHP_EOL;
                    $info .= 'Date: ' . $error['timestamp'] . PHP_EOL;
                    $info .= 'Description: ' . $error['description'] . PHP_EOL;
                    $info .= 'Exception: ' . $error['exception'] . PHP_EOL;
                    $info .= PHP_EOL . '[Stack trace] (maybe in one of these files has the error)' . PHP_EOL;
                    Standard::output($info);
                    
                    $count = 0;

                    foreach($error['trace'] as $hop) {
                        Standard::output($count . ' : In ' . $hop['file'] . ' at line ' . $hop['line'], 'INFO');
                        $count++;
                    }

                    echo PHP_EOL;

                    $flag = true;
                }
            }

            if(!$flag) {
                Standard::output("Invalid error id.", 'FAILURE');
            }
        }
    }