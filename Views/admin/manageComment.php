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
                <td><?= $comment->comment_active ?></td>
                <td>
                    <div class="switch">
                        <label>
                            Off
                            <input type="checkbox">
                            <span class="lever"></span>
                            On
                        </label>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>