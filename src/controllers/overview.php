<?php
    global $rsa;

    if (!$rsa) {
        require_once '../src/config.php';
        header('Location:' . SELF_HTTP_ADDR);
        die();
    }

    echo '
        <div class="panel panel-info">
            <div class="panel-heading">Inicializační proměnné</div>
            <div class="panel-body">
                <h4>Prvočíslo p (velikost ' . strlen(gmp_strval($rsa->getP(), 2)) . ' bitů):</h4>
                <div class="hausnumero">' . $rsa->getP() . '</div>
                
                <h4>Prvočíslo q (velikost ' . strlen(gmp_strval($rsa->getQ(), 2)) . ' bitů):</h4>
                <div class="hausnumero">' . $rsa->getQ() . '</div>
                
                <h4>Číslo x = (p -1) * (q - 1) (velikost ' . strlen(gmp_strval($rsa->getTotiet(), 2)) . ' bitů):</h4>
                <div class="hausnumero lastnumero">' . $rsa->getTotiet() . '</div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">Veřejný klíč</div>
            <div class="panel-body">
                <h4>Veřejný exponent e (velikost ' . strlen(gmp_strval($rsa->getPublic(), 2)) . ' bitů):</h4>
                <div class="hausnumero">' . $rsa->getPublic() . '</div>
                
                <h4>Modul n = p * q (velikost ' . strlen(gmp_strval($rsa->getModul(), 2)) . ' bitů):</h4>
                <div class="hausnumero lastnumero">' . $rsa->getModul() . '</div>
            </div>
        </div>
        <div class="panel panel-danger">
            <div class="panel-heading">Soukromý (privátní) klíč</div>
            <div class="panel-body">
                <h4>Soukromý exponent d, pro který platí (d * e) % n = 1 (velikost ' . strlen(gmp_strval($rsa->getPrivate(), 2)) . ' bitů):</h4>
                <div class="hausnumero">' . $rsa->getPrivate() . '</div>
                
                <h4>Modul n = p * q (velikost ' . strlen(gmp_strval($rsa->getModul(), 2)) . ' bitů):</h4>
                <div class="hausnumero lastnumero">' . $rsa->getModul() . '</div>
            </div>
        </div>
    ';
?>