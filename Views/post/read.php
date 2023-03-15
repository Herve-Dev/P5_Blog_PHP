<div class="row">
    <div class="col s12 m7">
        <div class="card">
            <div class="card-image">
                <img src="/includes/<?= $post->image ?>">
                <span class="card-title"><?= $post->title ?></span>
            </div>
            <div class="card-content">
                <p><?= $post->content ?></p><br>
                <p> crée le : <?= $post->createdAt ?></p><br>
            </div>
            <div class="card-action">
                <a href="/PostComment/addComment/<?= $post->id ?>">Ajouter un commentaire</a>
                <a href="post/deletePost/<?= $post->id ?>">Supprimez le post</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col s12 m6">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
         <p> ok</p>
        </div>
        <div class="card-action">
          <a href="#">This is a link</a>
          <a href="#">This is a link</a>
        </div>
      </div>
    </div>
  </div>