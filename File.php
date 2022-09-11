<?php
    class File {
        public function read($file_path) {
            if (!file_exists($file_path)) {
                return false;
            }
            $fp = fopen($file_path, 'r');
            $lines = [];
            if ($fp) {
                while($line = fgets($fp,4096)) {
                    $lines[] = $line;
                }
            }
            fclose($fp);
            return $lines;
        }
        public function write($file_path, $text) {
            $f = fopen($file_path, 'w');
            fputs($f, $text);
            fclose($f);
        }
    }
?>