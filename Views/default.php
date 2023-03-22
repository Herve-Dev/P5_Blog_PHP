<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#" type="image/x-icon">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="/css/style.css" type="text/css">
    <title>HERVE BLOG</title>
</head>

<body>
    <nav>
        <div class="nav-wrapper blue darken-3">
            <a href="/" class="brand-logo"> HERVE BLOG</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">

                <?php if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) : ?>
                    <li><a href="/">Acceuil</a></li>

                    <?php if ($_SESSION['user']['role'] === 'ADMIN') : ?>
                        <li><a href="/post/addPost">Ajouter un post</a></li>
                    <?php endif; ?>

                    <li><a href="/post">Publications</a></li>
                    <li><a href="/image/Cv/Intégrateur_Developpeur_Web.pdf" download>curriculum vitae</a></li>
                    <li>
                        <a class="dropdown-trigger" href="#!" data-target="dropdown1">
                            <div class="chip">
                                <img src="/image/avatar_image/<?php echo $_SESSION['user']['avatar'] ?>" alt="Contact Person">
                                <?php echo $_SESSION['user']['username']; ?>
                            </div>
                            <i class="material-icons right">
                                arrow_drop_down
                            </i>
                        </a>
                        <ul id="dropdown1" class="dropdown-content">
                            <li><a href="/user/updatePassword/<?php echo $_SESSION['user']['id']?>">Modifier mon mot de passe</a></li>
                            <?php if ($_SESSION['user']['role'] === 'ADMIN') : ?>
                                <li><a href="/admin/index">Espace administration</a></li>
                            <?php endif; ?>    
                            <li class="divider"></li>
                        <li><a href="/user/logout">Se déconnecter</a></li>
                    </ul>
                    </li>
                    

                <?php else : ?>

                    <li><a href="/user/register">S'inscrire</a></li>
                    <li><a href="/user/login">Se connecter</a></li>

                <?php endif; ?>
            </ul>
        </div>
    </nav>
   
    <main class="container"> <?= $content ?></main>

    <footer class="page-footer blue darken-3">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h5 class="white-text">HERVE BLOG</h5>
                    <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h5 class="white-text">Links</h5>
                    <ul>
                        <li><a class="grey-text text-lighten-3" href="#!">Linkedin</a></li>
                        <li><a class="grey-text text-lighten-3" href="#!">Github</a></li>
                        <li><a class="grey-text text-lighten-3" href="/contact/sendMailContact">Me contacter</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                © 2023 Copyright Text
            </div>
        </div>
    </footer>
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="/js/index.js"></script>
</body>

</html>