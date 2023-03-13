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

                var_dump($title);

                // On instancie notre modèle
                $postModel = new PostModel;

                // On hydrate 
                $postModel->setTitle($title)
                    ->setChapo($chapo)
                    ->setContent($content)
                    ->setUser_id($_SESSION['user']['id']);

                // On enregistre
                //$postModel->create();

                //On redirige
                $_SESSION['message'] = "Votre post a été enregistré avec succès";
                //header('Location: /');
                //exit;
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
}