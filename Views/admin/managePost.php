<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Contenu</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($posts as $post) : ?>        
            <tr>
                <td><?= $post->post_title?></td>
                <td><?=$post->post_content?></td>
                <td>   
                    <a href="/post/updatePost/<?= $post->id_post ?>" class="waves-effect waves-light btn"><i class="material-icons right">create</i> Modifier</a>
                    <a href="/post/delePost/<?= $post->id_post ?>" class="waves-effect waves-light btn"><i class="material-icons right">delete</i>Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>        
    </tbody>
</table>
