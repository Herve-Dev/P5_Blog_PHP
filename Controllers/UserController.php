<?php
namespace App\Controllers;

use App\Core\Form;
use App\Core\SendMail;
use App\Models\UserModel;
use App\Utils\Utils;

class UserController extends Controller
{
    /**
     * Connexion des utilasteurs
     *
     * @return void
     */
    public function login()
    {
        $form = new Form;

        // Exemple de creation d'un form |$form->startForm('get ou post', 'login.php', ['class' => 'test', 'id' => 'test build'])
        // On termine avec $form->endForm() pour fermer la balise form
        $form->startForm()
            ->addLabelForm('email', 'E-mail :')
            ->addInput('email', 'email', ['class' => 'form-control' , 'id' => 'email'])
            ->addLabelForm('password', 'Mot de passe')
            ->addInput('password', 'password', ['id' => 'password', 'class' => 'form-control'])
            ->addButton('me connecter', ['class' => 'btn btn-primary'])
            ->endForm();

        $this->render('user/login', ['loginForm' => $form->create()]);
    }
    
    public function register()
    {
        $form = new Form;
        $form->startForm()
            ->addLabelForm('username', 'Pseudo :')
            ->addInput('text', 'username', ['class' => 'validate' , 'id' => 'username'])

            ->addLabelForm('email', 'E-mail :')
            ->addInput('email', 'email', ['class' => 'validate' , 'id' => 'email'])

            ->addLabelForm('password', 'Mot de passe :')
            ->addInput('password', 'password', ['id' => 'password', 'class' => 'validate'])

            ->addLabelForm('confirmPassword', ' Confirmer votre Mot de passe :')
            ->addInput('password', 'confirmPassword', ['id' => 'confirmPassword', 'class' => 'validate'])

            ->addButton("m'inscrire", ['class' => 'btn waves-effect waves-light'])
            ->endForm();

        $this->render('user/register', ['registerForm' => $form->create()]);
        
        // On vérifie si le formulaire est valide
        if (Form::validate($_POST, ['username','email', 'password', 'confirmPassword'])) {
            // Le formulaire est valide 
            
           
            // On "nettoie" les inputs avec strip_tags
            $username = strip_tags($_POST['username']);
            $email = strip_tags($_POST['email']);
            $pass = strip_tags($_POST['password']); 
            $confirmPassword = strip_tags($_POST['confirmPassword']);

            //On compare les mot de passe
            $comparePass = new Utils;
            $passHash = $comparePass->comparePass($pass,$confirmPassword);
            var_dump($passHash);
            
            if ($passHash === false) {
                return $passHash;
            } else {
                $cryptParamURL = Utils::encodeMailURL($email);
                $sendMail = new SendMail;
                $sendMail->sendmailAuth($email, $cryptParamURL);

                
            }


        }
    }
}