<nav class="blue darken-3">
    <ul id="slide-out" class="sidenav blue darken-3">
    <?php if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) : ?>
        <li>
            <div class="user-view white">
                <a href="#user"><img class="circle" src="/image/avatar_image/<?php echo $_SESSION['user']['avatar'] ?>"></a>
                <a href="#name"><span class="black-text name"><?php echo $_SESSION['user']['username'] ?></span></a>
                <li><a href="/">Acceuil</a></li>
                <?php if ($_SESSION['user']['role'] === 'ADMIN') : ?>
                    <li><a href="/post/addPost">Ajouter un post</a></li>
                <?php endif; ?>
                <li><a href="/post">Publications</a></li>
                <li><a href="/image/Cv/Intégrateur_Developpeur_Web.pdf" download>curriculum vitae</a></li>
                <li><a href="/user/updatePassword/<?php echo $_SESSION['user']['id'] ?>">Modifier mon mot de passe</a></li>
                <?php if ($_SESSION['user']['role'] === 'ADMIN') : ?>
                    <li><a href="/admin/index">Espace administration</a></li>
                <?php endif; ?>

                <li class="divider"></li>
                <li><a href="/user/logout">Se déconnecter</a></li>
            </div>
        </li>
    <?php else : ?>    
        <li><a href="/user/register">S'inscrire</a></li>
        <li><a href="/user/login">Se connecter</a></li>
    <?php endif; ?>   
    </ul>
    <a href="#" data-target="slide-out" class="sidenav-trigger "><i class="material-icons">menu</i></a>
</nav>