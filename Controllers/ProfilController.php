<?php
namespace App\Controllers;

use App\Models\UserModel;

class ProfilController extends Controller
{
    public function profilUser(int $idUser)
    {
        $userModel = new UserModel;
        $user = $userModel->findById($idUser);
        var_dump($user);

        $this->render('user/profilUser',['user' => $user]);
    }
}