<?php foreach ($posts as $post) : ?>
    <div class="row">
        <div class="col s12 m7">
            <div class="card">
                <div class="card-image">
                    <img src="/image/post_image/<?= $post->post_image ?>">
                    <span class="card-title"><?= $post->post_title?></span>
                </div>
                <div class="card-content">
                    <p><?= $post->post_chapo ?></p><br>
                    <p><?= $post->post_content ?></p><br>
                    <p> crée le : <?= $post->post_createdAt ?></p><br>
                </div>
                <div class="card-action">
                    <a href="post/read/<?= $post->id_post ?>">Lire l'article</a>
                    <?php if ($_SESSION['user']['role'] === 'ADMIN'): ?>
                        <a href="post/deletePost/<?= $post->id_post ?>">Supprimez le post</a>
                    <?php endif; ?> 
                </div>
            </div>
        </div>  
    </div>
<?php endforeach; ?>

