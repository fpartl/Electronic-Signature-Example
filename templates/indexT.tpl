<!DOCTYPE HTML>
<html lang="cs">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="">
        <meta name="author" content="František Pártl, A15B0305P">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap/dist/css/bootstrapFiles.css" rel="stylesheet">
        <title>Implemenatace elektronického podpisu</title>
        <link href="bootstrap/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <link href='http://fonts.googleapis.com/css?family=Dosis&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>Ukázka implementace elektronického podpisu </h1>
                <small>S využitím hashovací funkce SHA1 a asymetrické šifry RSA.</small>
            </div>
            <ul class="nav nav-tabs">
                {{ menu | raw }}
            </ul>
            {{ alert | raw }}
            <section class="sectionContent">
                {{ sectionContent | raw }}
            </section>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="scripts.js"></script>
    </body>
</html>