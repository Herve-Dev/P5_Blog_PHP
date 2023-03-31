<?php
namespace App\Controllers;

use App\Models\UserModel;

class EmailController extends Controller
{
    public function index(string $cryptParamURL)
    {
        //On decode en base64
        $base64Decode = base64_decode($cryptParamURL);

        //On décrypte le paramètre envoyé dans l'url
        $decryptParamUrl = openssl_decrypt($base64Decode, "AES-128-ECB", getenv('SECRET_KEY_OPENSSL'));

        //On verfie ci l'email correspond a l'email dans la base de donnée
        $userModel = new UserModel;
        $userEmail = $userModel->findOneByEmail($decryptParamUrl);

        if ($userEmail) {
            $userModel->updateAuthUser($decryptParamUrl);
            $this->render('email/index', [], 'default');
            header('Refresh: 5; /user/login');
        }else {
            $_SESSION['error'] = "Une erreur est survenu";
            header('Location: /');
        }  
    }
}