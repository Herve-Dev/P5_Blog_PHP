<div class="row">
  <div class="col s12 m7">
    <div class="card">
      <div class="card-image">
        <img src="/includes/<?= $post->post_image ?>">
        <span class="card-title"><?= $post->post_title ?></span>
      </div>
      <div class="card-content">
        <p><?= $post->post_content ?></p><br>
        <p> crée le : <?= $post->post_createdAt ?></p><br>
      </div>
      <div class="card-action">
        <a href="/PostComment/addComment/<?= $post->id_post ?>">Ajouter un commentaire</a>
        <a href="post/deletePost/<?= $post->id_post ?>">Supprimez le post</a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col s12 m6">
    <div class="card blue-grey darken-1">
      <div class="card-content white-text">
        <p> <?= $post->comment_content ?></p>
      </div>
      <div class="card-action">
        <a href="#">Supprimez mon commentaire</a>
        <a href="#">Mettre à jour mon commentaire</a>
      </div>
    </div>
  </div>
</div>