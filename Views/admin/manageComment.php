<table>
    <thead>
        <tr>
            <th>Contenu</th>
            <th>Actif</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($comments as $comment) : ?>
            <tr>
                <td><?= $comment->comment_content ?></td>
                <td class="td-comment-<?= $comment->id_comment ?>"><?= $comment->comment_active ?></td>
                <td>
                    <div class="switch">
                        <label>
                            Off
                            <input type="checkbox" class="switch-button" id="switch<?= $comment->id_comment?>" 
                            <?= $comment->comment_active ? 'checked' : '' ?> data-id="<?= $comment->id_comment ?>">
                            <span class="lever"></span>
                            On
                        </label>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>