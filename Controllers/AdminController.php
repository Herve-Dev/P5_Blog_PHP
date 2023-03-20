<?php
namespace App\Controllers;

use App\Models\PostCommentModel;
use App\Models\PostModel;

class AdminController extends Controller
{
    public function index()
    {
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id']) && $_SESSION['user']['role'] === 'ADMIN') {
            $this->render('/admin/index');
        }else {
            $_SESSION['error'] = "Vous n'avez l'autorisation";
            header('Location : /post/index');
            exit;
        }
    }

    public function managePost()
    {
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id']) && $_SESSION['user']['role'] === 'ADMIN') { 
            $postModel = new PostModel;
            $post = $postModel->findAll();
            $this->render('admin/managePost', ['posts' => $post]);
        }else {
            $_SESSION['error'] = "Vous n'avez l'autorisation";
            header('Location : /post/index');
            exit;
        }
    }

    public function manageComment()
    {
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id']) && $_SESSION['user']['role'] === 'ADMIN') { 
            $commentModel = new PostCommentModel;
            $comment = $commentModel->findAll();
            $this->render('admin/manageComment', ['comments' => $comment]);
        } else {
            $_SESSION['error'] = "Vous n'avez l'autorisation";
            header('Location : /post/index');
            exit;
        }
    }
}