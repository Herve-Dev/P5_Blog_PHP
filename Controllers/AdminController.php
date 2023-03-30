<?php
namespace App\Controllers;

use App\Models\PostCommentModel;
use App\Models\PostModel;

class AdminController extends Controller
{
    public function index()
    {
        if ($this->isAdmin()) {
            $this->render('/admin/index');
        }
    }

    public function managePost()
    {
        if ($this->isAdmin()) { 
            $postModel = new PostModel;
            $post = $postModel->findAll();
            $this->render('admin/managePost', ['posts' => $post]);
        }
    }

    public function manageComment()
    {
        if ($this->isAdmin()) { 
            $commentModel = new PostCommentModel;
            $comment = $commentModel->findAll();
            $this->render('admin/manageComment', ['comments' => $comment]);
        }
    }

    public function activeComment(int $idComment)
    {
        if ($this->isAdmin()) { 
            $commentModel = new PostCommentModel;
            $commentArray = $commentModel->findById($idComment);

                if ($commentArray) {
                    $comment = $commentModel->hydrate($commentArray);

                    $comment->setComment_active($comment->getComment_active() ? 0 : 1);

                    $columnTarget = 'id_comment';
                    $comment->update($idComment, $columnTarget);

                    $response = array(
                        "activate" => "commentaire activé",
                        "desactivate" => "commentaire désactivé"
                    );

                    echo json_encode($response);
                }
        }
    }

    public static function isAdmin()
    {
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id']) && $_SESSION['user']['role'] === 'ADMIN') {
            return true;
        } else {
            $_SESSION['erreur'] = "Vous n'avez pas accès à cette zone";
            header('Location: /');
            exit;
        }
    }

    public static function isUser()
    {
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
            return true;
        } else {
            $_SESSION['erreur'] = "Vous n'avez pas accès à cette zone";
            header('Location: /');
            exit;
        }
    }
}