<?php 
namespace App\Controllers;

use App\Core\Form;
use App\Models\PostCommentModel;

class PostCommentController extends Controller
{
    public function index()
    {
        // On instancie le modèle correspondant à la table
        $postCommentModel = new PostCommentModel;

        //On va chercher touts les commentaires
        $comments = $postCommentModel->findAll();

        //On génère la vue
        $this->render('comment/index', ['comments' => $comments ]);
    }

    public function addComment(int $idPost)
    {
        //On vérifie si lutilisateur est connecté
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
            //l'utilisateur est connecté

            if (Form::validate($_POST, ['content'])) {
                // Le formulaire est complet
                // On se protège contre les failles XSS
                // strip_tags, htmlentities, htmlspecialchars
                $comment = strip_tags($_POST['comment']);

                //On instancie notre modèle
                $postCommentModel = new PostCommentModel;

                // On hydrate
                $postCommentModel->setContent($comment)
                    ->setPost_id($idPost)
                    ->setUser_id($_SESSION['user']['id']);

                // On enregistre
                $postCommentModel->create();

                 //On redirige
                 $_SESSION['message'] = "Votre commentaire a été enregistré avec succès l'admin l'acceptera après modération";
                 header('Location: /post');
                 exit;
            }
        }
    }
}