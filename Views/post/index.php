<h1>Page des posts</h1>
<?php foreach ($posts as $post) : ?>
    <div class="row">
        <div class="col s12 m7">
            <div class="card">
                <div class="card-image">
                    <img src="/includes/<?= $post->image?>">
                    <span class="card-title"><?= $post->title?></span>
                </div>
                <div class="card-content">
                    <p><?= $post->content ?></p><br>
                    <p> crée le : <?= $post->createdAt ?></p><br>
                </div>
                <div class="card-action">
                    <a href="post/read <?= $post->id ?>">Lire l'article</a>
                    <a href="post/deletePost/<?= $post->id ?>">Supprimez le post</a>
                </div>
            </div>
        </div>  
    </div>
<?php endforeach; ?>