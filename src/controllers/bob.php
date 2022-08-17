<?php
    global $rsa, $event, $sha, $message;

    if (!$rsa || !$event || !$rsa->isReady() || !$sha) {
        require_once '../src/config.php';
        header('Location:' . SELF_HTTP_ADDR);
        die();
    }

    require_once '../src/sign/rsa_cryptor.php';

    $input = trim(@$_POST['message']);

    if ($message->getState() != DOESNT_EXISTS) {
         echo '
            <div class="panel panel-info">
                <div class="panel-heading">Šifrování otisku zprávy</div>
                <div class="panel-body">
                    <h4>Otisk zprávy vytvořený funkcí SHA1:</h4>
                    <div class="hausnumero">' . $sha->generate($message->getContent()) . '</div>

                    <h4>Bobův soukromý klíč pro zašifrování otisku:</h4>
                    <div class="hausnumero">' . $rsa->getPrivate() . '</div>

                    <h4>Zašifrovaný otisk:</h4>
                    <div class="hausnumero lastnumero">' . $message->getCryptedHash() . '</div>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">Odeslaná zpráva</div>
                <div class="panel-body">
                    <h4>Odeslaná zpráva:</h4>
                    <div class="hausnumero">' . $message->getContent() . '</div>

                    <h4>Otisk zprávy zašifrovaný bobovým soukromým klíčem:</h4>
                    <div class="hausnumero">' . $message->getCryptedHash() . '</div>

                    <div class="panel panel-warning innerPanel">
                        <div class="panel-heading">Certifikát</div>
                        <div class="panel-body">
                            <h4>Bobův veřejný klíč pro dešifrování otisku zprávy (číslo e):</h4>
                            <div class="hausnumero">' . $message->getPublicKey() . '</div>

                            <h4>Bobův veřejný klíč pro dešifrování otisku zprávy (číslo n):</h4>
                            <div class="hausnumero">' . $message->getModul() . '</div>

                            <h4>Ověření třetí stranou:</h4>
                            <div class="hausnumero lastnumero">' . $message->getCert() . '</div>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }
    else {
        if ($input == '') {
            echo '
                <p>S vygenerovanými klíči může Bob poslat Alici zprávu.</p>
                <h3>Napsat Alici novou zprávu</h3>
                <form method="post" action="?section=bob">
                    <div class="form-group">
                        <label for="messInput">Obsah zprávy</label>
                        <textarea class="form-control message" rows="5" id="messInput" name="message" placeholder="Např: Kup 10 rohlíků."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Podepsat a odeslat zprávu</button>
                </form>
            ';
        }
        else {
            $cryptor = new RSACryptor($rsa->getPrivate(), $rsa->getModul());

            if (!$cryptor->isReady())
                $event->set(DANGER, 'Chyba při šifrování.', '?section=bob');

            $hash = $sha->generate($input);
            $crypted = $cryptor->encrypt($hash);

            $message->send($input, $crypted, $rsa->getPublic(), $rsa->getModul(), CERT);
            $event->set(SUCCESS, 'Zpráva byla úspěšně odeslána. Nyní je na Oskarovi jestli chce zprávu upravit a pokusit se tak zmást Alici.', '?section=bob');
        }
    }
?>