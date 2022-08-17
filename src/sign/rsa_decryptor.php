<?php
    class RSADecryptor {
        private $e;
        private $n;
        private $ready;
        
        public function __construct($e, $n) {
            if ($this->isNumber($e) && $this->isNumber($n)) {
                $this->e = $e;
                $this->n = $n;
                $this->ready = true;
            }
        }
        
        public function isReady() {
            return $this->ready;
        }
        
        public function decrypt($num) {
            $m = gmp_powm($num, $this->e, $this->n);
            return $this->numberToString($m);
        }
        
        private function numberToString($num) {
            $bin = gmp_strval($num, 2);
            $binLen = strlen($bin);

            while ($binLen % 8 != 0) $binLen++;
            $bin = str_pad($bin, $binLen, '0', STR_PAD_LEFT);
            
            $binArr = str_split($bin);
            $temp = '';
            $result = '';
            
            foreach ($binArr as $c) {
                $temp .= $c;
                
                if (strlen($temp) == 8) {
                    $result .= chr(bindec($temp));
                    $temp = '';
                }
            }
            
            return $result;
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