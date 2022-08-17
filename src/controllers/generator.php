<?php
    global $rsa, $event;

    if (!$rsa || !$event) {
        require_once '../src/config.php';
        header('Location:' . SELF_HTTP_ADDR);
        die();
    }

    if ($rsa->isReady())
        $event->set(DANGER, 'Klíče již byly vygenerovány.', '?section=overview');

    $pqLen = trim(@$_REQUEST['pgLen']);
    $eLen = trim(@$_REQUEST['eLen']);

    if (is_numeric($pqLen) && is_numeric($eLen)) {
        $rsa->setPQLen($pqLen);
        $rsa->setELen($eLen);
        $rsa->generate();
        $event->set(SUCCESS, 'Klíče byly úspěšně vytvořeny.', '?section=overview');
    } 
    else {
        echo '
            <p class="secDesc">Bob zatím nemá vygenerován <b>veřejný a privátní klíč</b>. Tyto klíče jsou nezbytné pro podepsání vystavených dokumentů.</p>
            <h3>Generovat novou dvojici klíčů</h3>
            <form class="col-xs-12" method="post" action="?section=generator">
                <div class="row">
                    <div class="form-group col-sm-3">
                      <label for="pgInput" class="">Délka čísel p a q</label>
                      <input type="number" value="1024" class="form-control" name="pgLen" id="pgInput" placeholder="' . (($pqLen == '') ? 'Například 1024' : $pqLen) . '">
                    </div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-8">
                        Při velikostech nad 4096 bitů není zaručeno, že nebudete čekat na výsledek půl hodiny.
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-3">
                      <label for="eInput" class="">Délka veřejného klíče e</label>
                      <input type="number" value="64" class="form-control" name="eLen" id="eInput" placeholder="' . (($pqLen == '') ? 'Například 64' : $pqLen) . '">
                    </div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-8">
                        Veřejný exponent nesmí být delší než hodnota Eulerovy funkce x = (p - 1)(q - 1), tj. přibližně dvojnásobek čísel p a q. Volte prosím toto číslo malé. Obecně je toto číslo dlouhé 16 až 64 bitů.
                    </div>
                </div>
                <button type="submit" class="btn btn-primary pull-right">Generovat klíče</button>
            </form>
        ';
    }
?>