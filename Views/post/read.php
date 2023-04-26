<div class="row">
  <div class="col s12 m7">
    <div class="card">
      <div class="card-image">
        <img src="/image/post_image/<?= $post->post_image ?>">
        <span class="card-title"><?= $post->post_title ?></span>
      </div>
      <div class="card-content">
        <p><?= $post->post_chapo ?></p><br>
        <p ><?= $post->post_content ?></p><br>
        <p> crée le : <?= $post->post_createdAt ?></p><br>
        <p> Auteur : <?= $post->username ?></p>
      </div>
      <?php if (isset($_SESSION['user']) && $_SESSION['user']['role']) : ?>
      <div class="card-action">
        <ul class="collapsible">
          <li>
            <div class="collapsible-header"><i class="material-icons">add</i>Ajouter un commentaire</div>
            <div class="collapsible-body">
              <span>
                <?= $formAddComment ?>
              </span>
            </div>
          </li>
        </ul>
        

        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'ADMIN') : ?>
          <a href="/post/deletePost/<?= $post->id_post ?>">Supprimez le post</a>
        <?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php if ($comments !== null) : ?>
  <?php foreach ($comments as $comment) : ?>
    <div class="row">
      <div class="col s12 m6">
        <div class="card blue-grey darken-1">
          <div class="card-content white-text">
            <p id="comment-<?= $comment->id_comment ?>"> <?= $comment->comment_content ?></p>
            <p>Auteur du commentaire : <a href="/Profil/profilUser/<?= $comment->user_id ?>"> <?= $comment->username ?> </a></p>
            <p>Crée le : <?= $comment->comment_createdAt ?> </p>
          </div>
          <div class="card-action">
            <?php if (isset($_SESSION['user']) && $comment->user_id === $_SESSION['user']['id']) : ?>
              <a href="/PostComment/deleteComment/<?= $comment->id_comment ?>">Supprimez mon commentaire</a>
              <a href="/PostComment/updateComment/<?= $comment->id_comment ?>">Mettre à jour mon commentaire</a>
              <ul class="collapsible collaps<?= $comment->id_comment ?>">
                <li>
                  <div class="update-com collapsible-header" data-comment="<?= $comment->id_comment ?>" data-post="<?= $comment->id_post ?>" ><i class="material-icons">update</i>Mettre à jour mon commentaire</div>
                  <div class="collapsible-body" data-idcomment="<?= $comment->id_comment ?>">
                    <span class="span-form<?= $comment->id_comment ?> span-collapsible">
                      
                    </span>
                  </div>
                </li>
              </ul>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>