<div class="col s12 m8 offset-m2 l6 offset-l3">
    <div class="card-panel grey lighten-5 z-depth-1">
        <div class="row valign-wrapper">
            <div class="col s5">
                <img src="/image/avatar_image/<?= $user->avatar ?>" alt="avatar_user" class=" circle responsive-img"> <!-- notice the "circle" class -->
            </div>
            <div class="col s10">
                <span class="black-text">
                    <p> pseudo : <?= $user->username ?></p>
                    <?php if ($user->biography !== null): ?>
                        <p><?= $user->biography ?></p>
                    <?php else: ?>
                        pas encore de biographie
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </div>
</div>