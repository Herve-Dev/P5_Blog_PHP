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