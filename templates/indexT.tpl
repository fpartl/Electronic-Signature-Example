<!DOCTYPE HTML>
<html lang="cs">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="RSA example with SHA1 hash function.">
        <meta name="author" content="František Pártl">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
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

        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha256-H3cjtrm/ztDeuhCN9I4yh4iN2Ybx/y1RM7rMmAesA0k=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="scripts.js"></script>
    </body>
</html>