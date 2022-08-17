<?php
    class RSACryptor {
        private $d;
        private $n;
        private $ready = false;

        public function __construct($d, $n) {
            if ($this->isNumber($d) && $this->isNumber($n)) {
                $this->d = $d;
                $this->n = $n;
                $this->ready = true;
            }
        }

        public function isReady() {
            return $this->ready;
        }
        
        public function encrypt($str) {
            $m = $this->stringToNumber($str);
            $crypted = gmp_powm($m, $this->d, $this->n);
            return $crypted;
        }
        
        private function stringToNumber($str) {
            $strArr = str_split($str);
            $bin = '';
            
            foreach ($strArr as $c)
                $bin .= sprintf("%08d", decbin(ord($c)));
            
            return gmp_init($bin, 2);
        }
        
        private function isNumber($str) {
            $strArr = str_split($str);
            
            if ($strArr[0] == '0') return false;
            
            foreach ($strArr as $c) 
                if (!is_numeric($c)) return false;
            
            return true;
        }
    }
?>