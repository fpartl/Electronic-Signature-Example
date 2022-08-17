<?php
class SHA1Generator {
    public function __construct() {
        // if (PHP_INT_SIZE != 4) exit('SHA1Generator error: Wrong integer size! I can work only with 32bit integers.');
    }

    public function generate($str) {
        # Using standard sha1 funtion. Following code is working only with 32bit integers.
        return sha1($str);

        // $n = ((strlen($str) + 8) >> 6) + 1;
        
        // for ($i = 0; $i < $n * 16; $i++)
        //     $x[$i] = 0;
        
        // for ($i = 0; $i < strlen($str); $i++)
        //     $x[$i >> 2] |= ord(substr($str, $i, 1)) << (24 - ($i % 4) * 8);
        
        // $x[$i >> 2] |= 0x80 << (24 - ($i % 4) * 8);
        // $x[$n * 16 - 1] = strlen($str) * 8;
        
        // $a =  1732584193;
        // $b = -271733879;
        // $c = -1732584194;
        // $d =  271733878;
        // $e = -1009589776;
        
        // for ($i = 0; $i < count($x); $i += 16) {
        //     $olda = $a;
        //     $oldb = $b;
        //     $oldc = $c;
        //     $oldd = $d;
        //     $olde = $e;
            
        //     for ($j = 0; $j < 80; $j++) {
        //         $w[$j] = ($j < 16) ? $x[$i + $j] : $this->rotate($w[$j - 3] ^ $w[$j - 8] ^ $w[$j - 14] ^ $w[$j - 16], 1);
        //         $t = $this->add($this->add($this->rotate($a, 5), $this->shaIter($j, $b, $c, $d)), $this->add($this->add($e, $w[$j]), $this->getAditiv($j)));
        //         $e = $d;
        //         $d = $c;
        //         $c = $this->rotate($b, 30);
        //         $b = $a;
        //         $a = $t;
        //     }
            
        //     $a = $this->add($a, $olda);
        //     $b = $this->add($b, $oldb);
        //     $c = $this->add($c, $oldc);
        //     $d = $this->add($d, $oldd);
        //     $e = $this->add($e, $olde);
        // }
        
        // return sprintf('%08x%08x%08x%08x%08x', $a, $b, $c , $d, $e);
    }

    private function shaIter($t, $b, $c, $d) {
        if ($t < 20)
            return ($b & $c) | ((~$b) & $d);
        else if ($t < 40)
            return $b ^ $c ^ $d;
        else if ($t < 60)
            return ($b & $c) | ($b & $d) | ($c & $d);
        else 
            return $b ^ $c ^ $d;
    }

    private function getAditiv($t) {
        if ($t < 20)
            return 1518500249;
        else if ($t < 40)
            return 1859775393;
        else if ($t < 60)
            return -1894007588;
        else
            return -899497514;
    }
    
    private function add($x, $y) {
        $lsw = ($x & 0xFFFF) + ($y & 0xFFFF);
        $msw = ($x >> 16) + ($y >> 16) + ($lsw >> 16);
        
        return ($msw << 16) | ($lsw & 0xFFFF);
    }

    private function rotate($num, $cnt) {
        return ($num << $cnt) | $this->zeroPad($num, 32 - $cnt);
    }

    private function zeroPad($a, $b) {
        $bin = decbin($a);
        
        if (strlen($bin) < $b) 
            $bin = 0;
        else 
            $bin = substr($bin, 0, strlen($bin) - $b);
        
        for ($i = 0; $i < $b; $i++)
            $bin = '0' . $bin;
        
        return bindec($bin);
    }
}
?>