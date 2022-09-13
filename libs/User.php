<?php
    namespace Libs;
    class User {
        public $id, $name, $lines, $filesCount, $replacementCount;
        public function __construct($id, $name) {
            $this->id = $id;
            $this->name = $name;
            $this->lines = 0;
            $this->filesCount = 0;
            $this->replacementCount = 0;
        }

        public function getParams() {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'lines' => $this->lines,
            ];
        }
    }
?>