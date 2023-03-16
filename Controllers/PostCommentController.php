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
                    ->setPost_id($idPost)
                    ->setUser_id($_SESSION['user']['id'])
                    ->setComment_CreatedAt(date_create('now', timezone_open('Europe/Paris'))->format('Y-m-d H:i:s'));

                // On enregistre
                $postCommentModel->create();

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
}