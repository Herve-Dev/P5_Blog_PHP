<div class="row">
  <div class="col s12 m7">
    <div class="card">
      <div class="card-image">
        <img src="/image/post_image/<?= $post->post_image ?>">
        <span class="card-title"><?= $post->post_title ?></span>
      </div>
      <div class="card-content">
        <p><?= $post->post_chapo ?></p><br>
        <p><?= $post->post_content ?></p><br>
        <p> crée le : <?= $post->post_createdAt ?></p><br>
        <p> Auteur : <?= $post->username ?></p>
      </div>
      <div class="card-action">
        <a href="/PostComment/addComment/<?= $post->id_post ?>">Ajouter un commentaire</a>
        <?php if ($_SESSION['user']['role'] === 'ADMIN') : ?>
          <a href="post/deletePost/<?= $post->id_post ?>">Supprimez le post</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php if ($comments !== null) : ?>
  <?php foreach ($comments as $comment) : ?>
    <div class="row">
      <div class="col s12 m6">
        <div class="card blue-grey darken-1">
          <div class="card-content white-text">
            <p> <?= $comment->comment_content ?></p>
            <p>Auteur du commentaire : <?= $comment->username ?> </p>
          </div>
          <div class="card-action">
            <?php if($comment->user_id === $_SESSION['user']['id']):?>
              <a href="/PostComment/deleteComment/<?= $comment->id_comment ?>">Supprimez mon commentaire</a>
              <a href="/PostComment/updateComment/<?= $comment->id_comment ?>">Mettre à jour mon commentaire</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>