<?php namespace BitPHP\Cli\Igniters;

    require_once '../cli/data/HamlPHP/HamlPHP.php';
    require_once '../cli/data/HamlPHP/Storage/FileStorage.php';

    use \HamlPHP;
    use \FileStorage;
    use \BitPHP\Cli\StandardLibrary as Standard;
    use \BitPHP\Cli\FileWriter as File;
    use \BitPHP\Cli\Interfaces\Igniter;

    class TemplateCompiler implements Igniter {

        private static function readMeta() {
            $file = '../app/source/views/.meta';
            if( file_exists($file) ) {
                $meta = file_get_contents($file);
                return json_decode($meta, true);
            } else {
                return array();
            }
        }

        private static function writeMeta($meta) {
            $file = '../app/source/views/.meta';
            File::write($file, json_encode($meta, JSON_PRETTY_PRINT));
        }

        private static function parseOutputFile($file) {
            $outfile = str_replace(['../app/source/views/','.haml'], ['',''], $file);
            return '../app/views/' . $outfile .'.php';
        }

        private static function getFileList($dir) {

            $files = array();

            foreach (scandir($dir) as $file) {
                if ('.' === $file || '..' === $file || '.meta' === $file) continue;

                //Recursive
                if(is_dir($dir . $file)) {
                    $recursive = self::getFileList($dir . $file . '/');
                    $files = array_merge($files, $recursive);
                    continue;
                }

                $meta = self::readMeta();
                $file = $dir . $file;
                $output = self::parseOutputFile($file);
                $fileHash = md5($file);
                $lastMod = filectime($file);

                if( isset($meta[$fileHash]) ) {

                    if($meta[$fileHash] != $lastMod || !file_exists($output)) {
                        Standard::output("Changes on $file", 'EMPASIS');
                        $meta[$fileHash] = $lastMod;
                        self::writeMeta($meta);
                        $files[] = ['source' => $file, 'output' => $output];
                    } else {
                        Standard::output("Without changes for $file");
                    }

                } else {
                    $meta[$fileHash] = $lastMod;
                    self::writeMeta($meta);
                    $files[] = ['source' => $file, 'output' => $output];
                }
            }

            return $files;
        }

        public static function haml() {
            //see filectime()
            $parser = new HamlPHP(new FileStorage('../app/source/tmp/'));
            $parser->disableCache();

            if(!is_dir('../app/source/views/')) {
                Standard::output('Source views dir don\'t exists, it was created.');
                mkdir('../app/source/views/', 0777, true);
                return;
            }

            if(!is_dir('../app/views/'))
                mkdir('../app/views/', 0777, true);

            $files = self::getFileList('../app/source/views/');
            Standard::output('Parsing ' . count($files) . ' files...', 'INFO');

            foreach ($files as $file) {
                $content = $parser->parseFile($file['source']);

                Standard::output('Writing output ' . $file['output']);
                File::write($file['output'], $content);
            }

            Standard::output(count($files) . ' files were built.', 'FINAL');
        }

        public static function init() { }
    }