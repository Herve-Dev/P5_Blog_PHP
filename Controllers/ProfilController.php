<?php
namespace App\Controllers;

use App\Core\Form;
use App\Models\UserModel;

class ProfilController extends Controller
{
    public function profilUser(int $idUser)
    {
        $userModel = new UserModel;
        $user = $userModel->findById($idUser);

        $this->render('user/profilUser',['user' => $user]);
    }

    public function updateProfil(int $idUser)
    {
        if (AdminController::isUser()) {

            if (Form::validate($_POST, ['biography'])) {

                $biography = strip_tags($_POST['biography']);
                
                $user = new UserModel;
                $user->setBiography($biography);

                $fileImage = $_FILES['avatar'];

                //condition contrôle d'images
                if ($fileImage) {
                    $name = $_FILES["avatar"]['name'];
                    $folder = "image/avatar_image/$name";

                    if (!file_exists($folder)) {
                       $tempname = $_FILES["avatar"]["tmp_name"];
                       move_uploaded_file($tempname,$folder);
                       $user->setAvatar($name);
                    }
                }

                $user->update($idUser);
                header("Location: /Profil/profilUser/$idUser");
            }

               

            $formProfil = new Form;
            $formProfil->startForm()
            ->addLabelForm('avatar', 'Avatar :')
            ->addInputFiles('avatar')

            ->addLabelForm('biography', 'Biographie :')
            ->addTextarea('biography')

            ->addButton('Mettre à jour mon profil',['class' => 'add-post btn waves-effect waves-light'])
            ->endForm();
        
            $this->render('/user/updateProfil', ['formProfil' => $formProfil->create()]);
        }
          
    }
}