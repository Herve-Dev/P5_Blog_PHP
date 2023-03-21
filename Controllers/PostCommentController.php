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

            if (Form::validate($_POST, ['comment_content'])) {
                // Le formulaire est complet
                // On se protège contre les failles XSS
                // strip_tags, htmlentities, htmlspecialchars
                $comment = strip_tags($_POST['comment_content']);

                //On instancie notre modèle
                $postCommentModel = new PostCommentModel;

                // On hydrate
                $postCommentModel->setComment_Content($comment)
                    ->setId_post($idPost)
                    ->setUser_id($_SESSION['user']['id'])
                    ->setComment_CreatedAt(date_create('now', timezone_open('Europe/Paris'))->format('Y-m-d H:i:s'));

                // On enregistre
                $postCommentModel->request("SET FOREIGN_KEY_CHECKS = 0");
                $postCommentModel->create();
                $postCommentModel->request("SET FOREIGN_KEY_CHECKS = 1");

                //On redirige
                $_SESSION['message'] = "Votre commentaire a été enregistré avec succès l'admin l'acceptera après modération";
                header("Location: /post/read/$idPost");
                exit;
            }

            $form = new Form;

            $form->startForm()
                ->addLabelForm('comment_content','Votre commentaire :')
                ->addInput('text', 'comment_content', ['id' => 'comment', 'class' => 'validate'])

                ->addButton('Ajouter un nouveau commentaire',['class' => 'btn waves-effect waves-light'])
                ->endForm();


            $this->render('comment/addComment', ['formComment' => $form->create()]);
        }
    }

    public function updateComment(int $idComment)
    {
        //On verifie si l'utilisateur est connecté
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
            
            //On va vérifier si le commentaire existe dans la base
            // On instancie notre modèle
            $commentModel = new PostCommentModel;

            //On cherche le commentaire avec l'id
            $columnTarget = "id_comment";
            $comment = $commentModel->find($idComment, $columnTarget);
            var_dump($comment);

            //Si l'annonce n'existe pas, on retourne à la liste des posts
            if (!$comment) {
                http_response_code(404);
                $_SESSION['error'] = "Le post recherché n'existe pas";
                header('Location: /post');
                exit;
            }

            // On vérifie si l'utilisateur est propriétaire du commentaire
            if ($comment->user_id !== $_SESSION['user']['id']) {
                $_SESSION['error'] = "Vous devez être connecté(e) pour accéder à cette page ou vous n'avez pas d'autorisation pour acceder à cette ressource";
                header('Location: /post');
                exit;
            }

            // On traite le formulaire 
            if (Form::validate($_POST, ['comment_content'])) {
                // On se protège contre les failles XSS
                $commentContent = strip_tags($_POST['comment_content']);

                //On stock le comment 
                $commentModif = new PostCommentModel;

                // On hydrate 
                $commentModif->setId_post($comment->id_post)
                    ->setComment_content($commentContent)
                    ->setUser_id($_SESSION['user']['id'])
                    ->setId_comment($idComment);
                    var_dump($commentModif);
                    
                
                //Je choisis la colonne concernée      
                $columnTarget = "id_comment";

                // On met à jour le commentaire   
                $commentModif->update($comment->id_post, $columnTarget);

                var_dump($commentModif);

                //On redirige
                /*$_SESSION['message'] = "Votre post a été modifié avec succès";
                header('Location: /post');
                exit;*/

            }

            $form = new Form;

            $form->startForm()
                ->addLabelForm('comment_content','Commentaire :')
                ->addInput('text', 'comment_content', ['id' => 'title', 'class' => 'validate', 'value' => $comment->comment_content])

                ->addButton('mettre à jour mon commentaire',['class' => 'btn waves-effect waves-light'])
                ->endForm();

            // On envoie à la vue 
            $this->render('comment/updateComment', ['form' => $form->create()]);

        } else {
            $_SESSION['error'] = "Vous devez être connecté(e) pour accéder à cette page ou vous n'avez pas d'autorisation pour acceder à cette ressource";
            header('Location /users/login');
            exit;
        }
    }
}