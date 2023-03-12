<?php
namespace App\Controllers;

use App\Models\UserModel;

class EmailController extends Controller
{
    public function index(string $cryptParamURL)
    {
        //On décrypte le paramètre envoyé dans l'url
        $decryptParamUrl = openssl_decrypt($cryptParamURL, "AES-128-ECB", getenv('SECRET_KEY_OPENSSL'));

        //On verfie ci l'email correspond a l'email dans la base de donnée
        $userModel = new UserModel;
        $userEmail = $userModel->findOneByEmail($decryptParamUrl);

        if ($userEmail) {
            $userModel->updateAuthUser($decryptParamUrl);
        }

        //On renvoie vers la vue 
        $this->render('email/index', [], 'default');
        header('Refresh: 5; /user/login');
    }
}