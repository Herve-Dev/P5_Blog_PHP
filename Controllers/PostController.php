<?php
namespace App\Controllers;

use App\Core\Form;
use App\Models\PostCommentModel;
use App\Models\PostModel;

class PostController extends Controller
{
    /**
     * Cette méthode affichera une page listant touts les posts
     *de la base de données
     * @return void
     */
    public function index()
    {
        // On instancie le modèle correspondant à la table "post"
        $postModel = new PostModel;

        //On va chercher touts les posts
        $post = $postModel->findAll();

        //On génère la vue
        $this->render('post/index', ['posts' => $post ]);
    }

    /**
     * Cette mehode affiche 1 post
     *
     * @param integer $id
     * @return void
     */
    public function read(int $idPost, string $valueBind = '')
    {
        //On instancie le modèle
        $postModel = new PostModel;

        //On cherche l'autheur lié au post
        $post = $postModel->findPostWithAuthor($idPost);

        //On cherche les commentaires lié au post
        $comments = $postModel->findPostWithComment($idPost);

        $formComment = new Form;
        $formComment->startForm()
            ->addLabelForm('comment_content','Votre commentaire :')
            ->addTextarea('comment_content', ['id' => 'comment', 'class' => 'validate'])

            ->addButton('Ajouter un nouveau commentaire',['class' => 'btn waves-effect waves-light'])
            ->endForm();
        $formAddComment = $formComment->create();
        
        //J'apelle la fonction addComment pour le collapsible
        PostCommentController::addComment($idPost); 
        
        $formUpdateComment = new Form;
        $formUpdateComment->startForm()
            ->addLabelForm('comment_content', 'Commentaire :')
            ->addInput('text', 'comment_content', ['id' => 'update-input', 'class' => 'validate comment-input' , 'value' => $valueBind])

            ->addButton('mettre à jour mon commentaire', ['class' => 'btn waves-effect waves-light'])
            ->endForm();
        $formUpdate = $formUpdateComment->create();  

        //On envoie à la vue
        $this->render('post/read', compact('post','comments', 'formAddComment'));
        
    }

    public function findCom(int $idComment)
    {
        $commentModel = new PostCommentModel;
        $comment = $commentModel->findById($idComment);
        $result = $comment->comment_content;
        echo json_encode($result);
        die();
    }


    public function updateCom(int $idComment, string $data)
    {
        echo var_dump('ok');
    }

    public function addPost()
    {
        //On vérifie si lutilisateur est connecté et qu'il a un role admin
        if (AdminController::isAdmin()) {
            //l'utilisateur est connecté

            if (Form::validate($_POST,['post_title', 'post_chapo', 'post_content'])) {
                // Le formulaire est complet
                // On se protège contre les failles XSS
                // strip_tags, htmlentities, htmlspecialchars
                $title = strip_tags($_POST['post_title']);
                $chapo = strip_tags($_POST['post_chapo']);
                $content = strip_tags($_POST['post_content']);

                // On instancie notre modèle
                $postModel = new PostModel;

                //A REFACTORISER
                if ($_FILES['post_image']) {
                    $name = $_FILES["post_image"]['name'];
                    $folder = "image/post_image/$name";

                    if (file_exists($folder)) {
                        $postModel->setPost_image($name);

                    }else{
                        $tempname = $_FILES["post_image"]["tmp_name"];
                        move_uploaded_file($tempname,$folder);
                        $postModel->setPost_image($name);
                    }
                }

                // On hydrate 
                $postModel->setPost_title($title)
                    ->setPost_chapo($chapo)
                    ->setPost_content($content)
                    ->setUser_id($_SESSION['user']['id']);
        
                // On enregistre
                $postModel->create();

                //On redirige
                $_SESSION['message'] = "Votre post a été enregistré avec succès";
                header('Location: /post');
                exit;
            }

            $form = new Form;

            $form->startForm()
                ->addLabelForm('post_title','Titre :')
                ->addInput('text', 'post_title', ['id' => 'title', 'class' => 'validate'])

                ->addLabelForm('post_chapo', 'chapô :')
                ->addInput('text', 'post_chapo', ['id'=> 'chapo', 'class' => 'validate'])

                ->addLabelForm('post_content', 'contenu :')
                ->addInput('text', 'post_content', ['id' => 'content', 'class' => 'validate'])

                ->addLabelForm('post_image', 'image :')
                ->addInputFiles()

                ->addButton('Ajouter un nouveau post',['class' => 'btn waves-effect waves-light'])
                ->endForm();

            $this->render('post/addPost', ['form' => $form->create()]);
        }
    }

    /**
     * Fontion pour modifier un post
     *
     * @param integer $id
     * @return void
     */
    public function updatePost(int $id)
    {
        //On verifie si l'utilisateur est connecté
        if (AdminController::isAdmin()) {
            
            //On va vérifier si le post existe dans la base
            // On instancie notre modèle
            $postModel = new PostModel;

            //On cherche le post avec l'id
            $post = $postModel->findById($id);

            //Si le post n'existe pas, on retourne à la liste des posts
            if (!$post) {
                http_response_code(404);
                $_SESSION['error'] = "Le post recherché n'existe pas";
                header('Location: /post');
                exit;
            }

            // On vérifie si l'utilisateur est propriétaire du post
            $userSessionId = $_SESSION['user']['id'];
            if ($post->user_id !== $userSessionId) {
                $_SESSION['error'] = "Vous devez être connecté(e) pour accéder à cette page ou vous n'avez pas d'autorisation pour acceder à cette ressource";
                header('Location: /post');
                exit;
            }

            // On traite le formulaire 
            if (Form::validate($_POST, ['post_title', 'post_chapo', 'post_content'])) {
                // On se protège contre les failles XSS
                $title = strip_tags($_POST['post_title']);
                $chapo = strip_tags($_POST['post_chapo']);
                $content = strip_tags($_POST['post_content']);

                //On stock le post 
                $postModif = new PostModel;

                // On hydrate 
                $postModif->setId_post($post->id_post)
                    ->setPost_title($title)
                    ->setPost_Chapo($chapo)
                    ->setPost_Content($content);
                
                //Je choisis la colonne concernée      
                $columnTarget = "id_post";

                // On met à jour le post   
                $postModif->update($post->id_post, $columnTarget);

                var_dump($postModif);

                //On redirige
                $_SESSION['message'] = "Votre post a été modifié avec succès";
                header('Location: /post');
                exit;

            }

            $form = new Form;

            $form->startForm()
                ->addLabelForm('post_title','Titre :')
                ->addInput('text', 'post_title', ['id' => 'title', 'class' => 'validate', 'value' => $post->post_title])

                ->addLabelForm('post_chapo', 'chapô :')
                ->addInput('text', 'post_chapo', ['id'=> 'chapo', 'class' => 'validate', 'value' => $post->post_chapo])

                ->addLabelForm('post_content', 'contenu :')
                ->addInput('text', 'post_content', ['id' => 'content', 'class' => 'validate', 'value' => $post->post_content])

                ->addLabelForm('post_image', 'image :')
                ->addInputFiles()

                ->addButton('mettre à jour le post',['class' => 'btn waves-effect waves-light'])
                ->endForm();

            // On envoie à la vue 
            $this->render('post/updatePost', ['form' => $form->create()]);
        }
    }

    /**
     * Fonction pour supprimez un post
     *
     * @param integer $id
     * @return void
     */
    public function deletePost(int $id)
    {
        //On verifie si l'utilisateur est connecté et est admin
        if (AdminController::isAdmin()) {
            $postDelete = new PostModel;

            //Je choisis la colonne concernée      
            $columnTarget = "id_post";

            $postDelete->delete($id, $columnTarget);
            header('Location: /post');
        } 
    }
}