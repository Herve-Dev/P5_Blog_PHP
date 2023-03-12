<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <title>Titre</title>
</head>

<body>
    <nav>
        <div class="nav-wrapper blue darken-3">
            <a href="/" class="brand-logo ">MON BLOG</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="/">Acceuil</a></li>
                <li><a href="/post">Mes Publications</a></li>
            </ul>
        </div>
    </nav>

    <div class="container"> <?= $content ?></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>

</html>