<?php
    class RSAGenerator {
        private $pqLen;
        private $publicLen;
        private $p;
        private $q;
        private $n;
        private $x;
        private $e;
        private $d;
        private $ready;
        
        public function __construct() {
            $this->pqLen = PRIME_NUMBER_SIZE;
            $this->publicLen = PUBLIC_KEY_SIZE;
            $this->initialize();
        }
        
        public function isReady() {
            return $this->ready;
        }
        
        public function setPQLen($len) {
            if (is_numeric($len) && $len > 0)
                $this->pqLen = $len;
        }
        
        public function setELen($len) {
             if (is_numeric($len) && $len > 0)
                $this->publicLen = $len;
        }
        
        public function getTotiet() {
            return ($this->ready) ? $this->x : UNDEFINED;
        }
        
        public function getP() {
            return ($this->ready) ? $this->p : UNDEFINED;
        }
        
        public function getQ() {
            return ($this->ready) ? $this->q : UNDEFINED;
        }
        
        public function getPrivate() {
            return ($this->ready) ? $this->d : UNDEFINED;
        }
        
        public function getPublic() {
            return $this->ready ? $this->e : UNDEFINED;
        }
        
        public function getModul() {
            return $this->ready ? $this->n : UNDEFINED;
        }
        
        private function initialize() {
            if (isset($_SESSION[SESSION_VARIABLE])) {
                $this->p = $_SESSION[SESSION_VARIABLE]['p'];
                $this->q = $_SESSION[SESSION_VARIABLE]['q'];
                $this->n = $_SESSION[SESSION_VARIABLE]['n'];
                $this->x = $_SESSION[SESSION_VARIABLE]['x'];
                $this->e = $_SESSION[SESSION_VARIABLE]['e'];
                $this->d = $_SESSION[SESSION_VARIABLE]['d'];
                $this->ready = true;
            }
            else $this->ready = false;
        }
        
        private function save() {
            if (isset($_SESSION[SESSION_VARIABLE]))
                unset($_SESSION[SESSION_VARIABLE]);
            
            $_SESSION[SESSION_VARIABLE] = array(
                'p' => $this->p,
                'q' => $this->q,
                'n' => $this->n,
                'x' => $this->x,
                'e' => $this->e,
                'd' => $this->d
            );
        }
        
        public function generate() {
            if (!$this->pqLen || !$this->publicLen) return;
            
            mt_srand(time());
            
            $this->p = $this->genPrime($this->pqLen);
            $this->q = $this->genPrime($this->pqLen);
            $this->n = gmp_mul($this->p, $this->q);
            $this->x = gmp_mul(gmp_sub($this->p, 1), gmp_sub($this->q, 1));
            $this->e = $this->genPublicKey($this->publicLen, $this->x);
            $this->d = $this->extendedEuclid($this->e, $this->x);
            
            $this->save();
            $this->ready = true;
        }
        
        private function genPrime($bitLen) {
            $text = '1';
            
            for ($i = 0; $i < $bitLen - 1; $i++)
                $text .= mt_rand(0, 1);
            
            return gmp_nextprime(gmp_init($text, 2));
        }
        
        private function genPublicKey($bitLen, $x) {
            $result;
            
            do {
                $result = $this->genPrime($bitLen);
            } while ($result >= $x || gmp_mod($x, $result) == 0);
            
            return $result;
        }
        
        private function extendedEuclid($e, $n) {
            $eUnchanged = $e;
            $x = gmp_init('0', 10);
            $y = gmp_init('1', 10);
            $lastx = gmp_init('1', 10);
            $lasty = gmp_init('0', 10);
            
            if (gmp_cmp($n, $e) > 0) {
                $eUnchanged = $n;
                $temp = $e;
                $e = $n;
                $n = $temp;
            }
            
            while (gmp_cmp($n, '0') != 0) {
                $q = gmp_div($e, $n);
                $temp1 = gmp_mod($e, $n);
                $e = $n;
                $n = $temp1;
                
                $temp2 = $x;
                $x = gmp_sub($lastx, gmp_mul($q, $x));
                $lastx = $temp2;
                
                $temp3 = $y;
                $y = gmp_sub($lasty, gmp_mul($q, $y));
                $lasty = $temp3;
            }

            return gmp_add($lasty, $eUnchanged);
        }
    }
?>