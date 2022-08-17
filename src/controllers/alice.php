<?php
    global $message, $sha, $event;

    if (!$message || !$sha || !$event) {
        require_once '../src/config.php';
        header('Location:' . SELF_HTTP_ADDR);
        die();
    }

    require_once '../src/sign/rsa_decryptor.php';

    if ($message->getState() != PASSED) echo '<div class="text-center silence">Alice zatím nepřijala žádnou zprávu.</div>';
    else {
        $decryptor = new RSADecryptor($message->getPublicKey(), $message->getModul());
        
        $myHash = $sha->generate($message->getUpdatedContent());
        $receivedHash = $decryptor->decrypt($message->getCryptedHash());
        
        if (isset($_GET['destroyMessage'])) {
            $message->destroy();
            $event->set(($myHash == $receivedHash) ? SUCCESS : DANGER, (($myHash == $receivedHash) ? 'Alice s úsměvem přijala bobovu zprávu.' : 'Alice oznamuje Bobovi, že správa nebyla ověřena.'), '?section=bob');
        }
        
        echo '
            <div class="panel panel-info">
                <div class="panel-heading">Zpráva přijatá od Boba</div>
                <div class="panel-body">
                    <h4>Obsah zprávy:</h4>
                    ' . $message->getUpdatedContent() . '

                    <h4>Otisk zprávy zašifrovaný bobovým soukromým klíčem:</h4>
                    <div class="hausnumero">' . $message->getCryptedHash() . '</div>

                    <div class="panel panel-warning innerPanel">
                        <div class="panel-heading">Certifikát</div>
                        <div class="panel-body">
                            <h4>Bobův veřejný klíč pro dešifrování otisku zprávy (číslo e):</h4>
                            <div class="hausnumero">' . $message->getPublicKey() . '</div>

                            <h4>Bobův veřejný klíč pro dešifrování otisku zprávy (číslo n):</h4>
                            <div class="hausnumero">' . $message->getModul() . '</div>

                            <h4>Certifikát ověřující identitu Boba:</h4>
                            <div class="hausnumero lastnumero">' . $message->getCert() . '</div>
                       </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-' . (($myHash == $receivedHash) ? 'success' : 'danger') . '">
                <div class="panel-heading">Ověření pravosti zprávy</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-5 leftSubPanel">
                            <div class="text-center hash">
                                <h4>SHA1 otisk přijaté zprávy:</h4>
                                ' . $myHash . '
                            </div>
                        </div>
                        <div class="col-sm-2 text-center resultMark">
                            <span class="' . (($myHash == $receivedHash) ? 'text-success">=' : 'text-danger">&ne;') . '</span>
                        </div>
                        <div class="col-sm-5">
                            <div class="text-center hash">
                                <h4>Dešifrovaný otisk zprávy:</h4>
                                ' . $receivedHash . '
                            </div>
                        </div>
                    </div>
                    <div class="text-center resultText ' . (($myHash == $receivedHash) ? 'text-success' : 'text-danger') . '">
                        ' . 
                            (($myHash == $receivedHash)
                                ? 'Otisky zprávy se shodují, takže tuto zprávu skutečně poslal Bob.'
                                : 'Otisky jsou rozdílné. Přijatá zpráva byla při přenosu pozměněna!'
                            )
                        . '
                        <a href="?section=alice&destroyMessage">
                            <button type="button" class="btn btn-' . (($myHash == $receivedHash) ? 'primary' : 'warning') . ' finishButton">
                                ' . 
                                    (($myHash == $receivedHash)
                                        ? 'Označit zprávu jako přečtenou'
                                        : 'Zahodit neověřenou zprávu'
                                    )
                                . '
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        ';
    }
?>