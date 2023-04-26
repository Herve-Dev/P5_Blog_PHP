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
        $comments = $postCommentModel->findAllComment();

        //On génère la vue
        $this->render('comment/index', ['comments' => $comments]);
    }

    public static function addComment(int $idPost)
    {

            if (Form::validate($_POST, ['comment_content'])) {
                // Le formulaire est complet
                // On se protège contre les failles XSS
                // strip_tags, htmlentities, htmlspecialchars
                $comment = strip_tags($_POST['comment_content']);

                //On instancie notre modèle
                $postCommentModel = new PostCommentModel;

                // On hydrate
                $userSessionId = $_SESSION['user']['id'];
                $postCommentModel->setComment_Content($comment)
                    ->setId_post($idPost)
                    ->setUser_id($userSessionId)
                    ->setComment_CreatedAt(date_create('now', timezone_open('Europe/Paris'))->format('Y-m-d H:i:s'));

                // On enregistre
                $postCommentModel->create();

                //On redirige
                echo "<div class='bloc-msg-good'> Votre commentaire a été enregistré avec succès l'admin l'acceptera après modération </div>";
                header("refresh:2; /post/read/$idPost");
            }
    }

    public function updateComment(int $idComment)
    {

            //On va vérifier si le commentaire existe dans la base
            // On instancie notre modèle
            $commentModel = new PostCommentModel;

            //On cherche le commentaire avec l'id
            $comment = $commentModel->findById($idComment);

            //Si l'annonce n'existe pas, on retourne à la liste des posts
            if (!$comment) {
                http_response_code(404);
                $_SESSION['error'] = "Le post recherché n'existe pas";
                header('Location: /post');
            }

            // On vérifie si l'utilisateur est propriétaire du commentaire
            $userSessionId = $_SESSION['user']['id'];

            if ($comment->user_id !== $userSessionId) {
                echo "<div class='bloc-msg-bad'> Vous devez être connecté(e) pour accéder à cette page ou vous n'avez pas d'autorisation pour acceder à cette ressource </div>";
                header("refresh:2; /post"); 
            }

            // On traite le formulaire 
            if (Form::validate($_POST, ['comment_content'])) {
                // On se protège contre les failles XSS
                $commentContent = strip_tags($_POST['comment_content']);

                //On stock le comment 
                $commentModif = new PostCommentModel;

                // On met à jour le commentaire   
                $commentModif->updateComment($idComment, $commentContent);

                //On redirige
                echo "<div class='bloc-msg-good'> Votre post a été modifié avec succès </div>";
                header("refresh:2; /post");
                
            }

            $formUpdateComment = new Form;

            $formUpdateComment->startForm()
                ->addLabelForm('comment_content', 'Commentaire :')
                ->addInput('text', 'comment_content', ['id' => 'title', 'class' => 'validate', 'value' => $comment->comment_content])

                ->addButton('mettre à jour mon commentaire', ['class' => 'btn waves-effect waves-light'])
                ->endForm();
            // On envoie à la vue 
            $this->render('comment/updateComment', ['form' => $formUpdateComment->create()]);
    }

    public function deleteComment(int $idComment)
    {

        $commentDelete = new PostCommentModel;

        $commentDelete->deleteComment($idComment);

        echo "<div class='bloc-msg-bad'> Votre post a été supprimez avec succes </div>";
        header("refresh:2; /post");
       
    }
}
