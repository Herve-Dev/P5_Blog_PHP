<?php
namespace App\Controllers;

use App\Core\Form;
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
    public function read(int $id)
    {
        //On instancie le modèle
        $postModel = new PostModel;

        //On va chercher 1 post
        //$post = $postModel->find($id);

        //On cherche les commentaires lier au post
        $post = $postModel->findPostWithcomment($id);

        //On envoie à la vue
        $this->render('post/read', compact('post'));
    }

    public function addPost()
    {
        //On vérifie si lutilisateur est connecté
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
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

                if ($_FILES['image']) {
                    $name = $_FILES["image"]['name'];
                    $folder = "../includes/$name";
                    $tempname = $_FILES["image"]["tmp_name"];
                    move_uploaded_file($tempname,$folder);
                    $postModel->setPost_image($name);
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
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
            
            //On va vérifier si le post existe dans la base
            // On instancie notre modèle
            $postModel = new PostModel;

            //On cherche l'annonce avec l'id
            $post = $postModel->findById($id);

            //Si l'annonce n'existe pas, on retourne à la liste des posts
            if (!$post) {
                http_response_code(404);
                $_SESSION['error'] = "Le post recherché n'existe pas";
                header('Location: /post');
                exit;
            }

            // On vérifie si l'utilisateur est propriétaire du post
            if ($post->user_id !== $_SESSION['user']['id']) {
                $_SESSION['error'] = "Vous n'avez pas accès à cette page";
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

        } else {
            $_SESSION['error'] = "Vous devez être connecté(e) pour accéder à cette page";
            header('Location /users/login');
            exit;
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
        $postDelete = new PostModel;

        //Je choisis la colonne concernée      
        $columnTarget = "id_post";

        $postDelete->delete($id, $columnTarget);
        header('Location: /post');
    }
}