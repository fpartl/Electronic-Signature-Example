<?php
    /* adresa na které je aplikace spuštěna */
    define('SELF_HTTP_ADDR', 'http://localhost');

    /* konstanty pro nastavení velikosti a umístění vygenerovaných RSA klíčů */
    define('SESSION_VARIABLE', 'RSA_KEY');
    define('PRIME_NUMBER_SIZE', 1024);
    define('PUBLIC_KEY_SIZE', 32);
    define('UNDEFINED', -1);

    /* konstanty pro nastavení zpráv */
    define('MESSAGE', 'MESSAGE');
    define('DOESNT_EXISTS', 0);
    define('SENT', 1);
    define('PASSED', 2);
    define('CERT', 'Certifikační autorita František Pártl strvrzuje, že tento veřejný klíč je opravdu Bobův.');
    
    /* konstanty pro nastavení upozornění */
    define('SUCCESS', 'success');
    define('DANGER', 'danger');
    $eventsTitle = array(
        SUCCESS => '<b>Výborně!</b>&nbsp;&nbsp;&nbsp;',
        DANGER => '<b>Chyba!</b>&nbsp;&nbsp;&nbsp;'
    );

    /* konstanty pro nastavení uživatelského rozhraní a zabezpečení */
    define('DEFAULT_SECTION', 'bob');
    $allowedSections = array('generator', 'overview', 'bob', 'oscar', 'alice');

    $menuItems = array(
        'overview' => 'Bobův klíč',
        'bob' => 'Bob',
        'oscar' => 'Oskar',
        'alice' => 'Alice'
    );
?>