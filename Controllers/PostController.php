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
        $this->render('post/index', ['posts' => $post]);
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
        $post = $postModel->find($id);

        //On envoie à la vue
        $this->render('post/read', compact('post'));
    }

    public function addPost()
    {
        //On vérifie si lutilisateur est connecté
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
            //l'utilisateur est connecté

            if (Form::validate($_POST,['title', 'chapo', 'content'])) {
                // Le formulaire est complet
                // On se protège contre les failles XSS
                // strip_tags, htmlentities, htmlspecialchars
                $title = strip_tags($_POST['title']);
                $chapo = strip_tags($_POST['chapo']);
                $content = strip_tags($_POST['content']);

                // On instancie notre modèle
                $postModel = new PostModel;

                if ($_FILES['image']) {
                    $name = $_FILES["image"]['name'];
                    $folder = "../includes/$name";
                    $tempname = $_FILES["image"]["tmp_name"];
                    move_uploaded_file($tempname,$folder);

                    $postModel->setImage($name);

                }

                // On hydrate 
                $postModel->setTitle($title)
                    ->setChapo($chapo)
                    ->setContent($content)
                    ->setUser_id($_SESSION['user']['id']);


                var_dump($postModel);
                // On enregistre
                $postModel->create();

                //On redirige
                $_SESSION['message'] = "Votre post a été enregistré avec succès";
                header('Location: /post');
                exit;
            }

            $form = new Form;

            $form->startForm()
                ->addLabelForm('title','Titre :')
                ->addInput('text', 'title', ['id' => 'title', 'class' => 'validate'])

                ->addLabelForm('chapo', 'chapô :')
                ->addInput('text', 'chapo', ['id'=> 'chapo', 'class' => 'validate'])

                ->addLabelForm('content', 'contenu :')
                ->addInput('text', 'content', ['id' => 'content', 'class' => 'validate'])

                ->addLabelForm('image', 'image :')
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
            $post = $postModel->find($id);

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
            if (Form::validate($_POST, ['title', 'chapo', 'content'])) {
                // On se protège contre les failles XSS
                $title = strip_tags($_POST['title']);
                $chapo = strip_tags($_POST['chapo']);
                $content = strip_tags($_POST['content']);

                //On stock le post 
                $postModif = new PostModel;

                // On hydrate 
                $postModif->setId($post->id)
                    ->setTitle($title)
                    ->setChapo($chapo)
                    ->setContent($content);

                // On met à jour le post    
                $postModif->update();

                //On redirige
                $_SESSION['message'] = "Votre post a été modifié avec succès";
                header('Location: /post');
                exit;

            }

            $form = new Form;

            $form->startForm()
                ->addLabelForm('title','Titre :')
                ->addInput('text', 'title', ['id' => 'title', 'class' => 'validate', 'value' => $post->title])

                ->addLabelForm('chapo', 'chapô :')
                ->addInput('text', 'chapo', ['id'=> 'chapo', 'class' => 'validate', 'value' => $post->chapo])

                ->addLabelForm('content', 'contenu :')
                ->addInput('text', 'content', ['id' => 'content', 'class' => 'validate', 'value' => $post->content])

                ->addLabelForm('image', 'image :')
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
}