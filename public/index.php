<?php

error_reporting(0);
session_start();

require_once '../vendor/autoload.php';
require_once '../src/config.php';
require_once '../src/event.php';
require_once '../src/sign/rsa_cryptor.php';
require_once '../src/sign/rsa_decryptor.php';
require_once '../src/sign/rsa_generator.php';
require_once '../src/sign/sha1.php';
require_once '../src/sign/message.php';

if (isset($_GET['exit'])) exitSession();

$event = new Event();
$rsa = new RSAGenerator();
$sha = new SHA1Generator();
$message = new Message();

$activeSection = initializeCurrSection(@$_GET['section']);

$tParams = array(
    'menu' => generateMenu($activeSection),
    'alert' => genEventMessage($event),
    'sectionContent' => phpWrapperFromFile('../src/controllers/' . $activeSection . '.php')
);

$loader = new Twig_Loader_Filesystem('../templates');
$twig = new Twig_Environment($loader);
$template = $twig->loadTemplate('indexT.tpl');
echo $template->render($tParams);

function initializeCurrSection($get) {
    global $allowedSections, $rsa, $event;
    
    if (!$rsa->isReady()) {
        if ($get != '' && $get != 'generator')
            $event->set(DANGER, 'Nejprve je nutné vygenerovat klíče pro Boba.', '');
            
        return reset($allowedSections);
    }
    else {
        if ($get == '') return DEFAULT_SECTION;
        else if (!in_array($get, $allowedSections)) {
            $event->set(DANGER, 'Fuck off!', '?section=' . DEFAULT_SECTION);
        }
        else return $get;
    }
}

function generateMenu($active) {
    global $menuItems, $rsa;
    $menu = '';
    
    if ($rsa->isReady()) {
        foreach ($menuItems as $section => $label)
            $menu .= '
                <li role="presentation" ' . (($active == $section) ? 'class="active"' : '') . '><a href="?section=' . $section . '" ' . (($active == $section) ? 'class="activeMenu"' : '') . '>' . $label . '</a></li>
            ';
        
        $menu .= '<a href="?exit"><button type="button" class="btn btn-primary pull-right">Ukončit ukázku</button></a>';
    }
    else $menu .= '<li role="presentation" class="active"><a href="#" class="activeMenu">Generátor RSA klíčů</a></li>';

    return $menu;
}

function genEventMessage($event) {
    global $eventsTitle;
    $eventMessage = '';
    
    if ($event->isExisting()) {
        $eventMessage = '
            <div class="alert alert-' . $event->getType() . ' alert-dismissible" role="alert" id="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                ' . $eventsTitle[$event->getType()] . $event->getMessage() . '
            </div>
        ';
    }
    
    $event->destroy();
    return $eventMessage;
}

function phpWrapperFromFile($filename) {
    ob_start();
    if (file_exists($filename) && !is_dir($filename))
        include($filename);
    $content = ob_get_clean();
    return $content;
}

function exitSession() {
    session_destroy();
    header('Location:' . SELF_HTTP_ADDR);
    die();
}
