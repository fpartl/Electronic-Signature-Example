<?php
    global $message, $sha, $event;

    if (!$message || !$sha || !$event) {
        require_once '../src/config.php';
        header('Location:' . SELF_HTTP_ADDR);
        die();
    }

    $newMessage = @$_POST['message'];

    if ($message->getState() == DOESNT_EXISTS) {
        echo '<div class="text-center silence">Je ticho&hellip; Bob s Alicí se asi nebaví.</div>';
    }
    else if ($message->getState() == SENT) {
        if ($newMessage != '') {
            $message->modify($newMessage);
            $event->set(SUCCESS, 'Zpráva byla úspěšně předána Alici.', '?section=oscar');
        }
        else {
            echo '
                <form method="post" action="?section=oscar">
                    <div class="panel panel-success">
                        <div class="panel-heading">Zachycená zpráva</div>
                        <div class="panel-body">
                            <h4>Obsah zprávy:</h4>
                            <textarea class="form-control message" rows="5" id="messInput" name="message" value="' . $message->getUpdatedContent() . '">' . $message->getUpdatedContent() . '</textarea>    

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
                            
                            <div class="submitArea">
                                <button type="submit" class="btn btn-primary pull-right subButton">Předat zprávu</button>
                                <button type="reset" class="btn btn-danger pull-right">Vrátit změny</button>
                            </div>
                        </div>
                    </div>
                </form>
            ';
        }
    }
    else {
        echo '
            <div class="panel panel-success">
                <div class="panel-heading">' . (($message->getContent() != $message->getUpdatedContent()) ? 'Upravená' : 'Nezměněná') . ' zpráva předaná Alici</div>
                <div class="panel-body">
                    <h4>' . (($message->getContent() != $message->getUpdatedContent()) ? 'Upravený o' : 'O') . 'bsah zprávy:</h4>
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
        ';
    }
?>