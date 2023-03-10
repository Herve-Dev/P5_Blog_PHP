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
       //On verifie si le formulaire est complet 
       if (Form::validate($_POST, ['email','password'])) {
            //Le formulaire est complet 
            //On va chercher dans la base de données l'utilisateur avec l'email entré

            $userModel = new UserModel;
            $userArray = $userModel->findOneByEmail(strip_tags($_POST['email']));

            //Si l'utilisateur n'existe pas 
            if (!$userArray) {
                // On envoie un message de session
                $_SESSION['error'] = "l'adresse e-mail et/ou le mot de passe est incorrect";
                header('Location: user/login');
                exit;
            }

            // L'utilisateur existe
            $user = $userModel->hydrate($userArray);
            
            // On vérifie si le mot de passe est correct
            if (password_verify($_POST['password'], $user->getPassword())) {
                //Le mot de passe est bon 
                // On crée la session
                $user->setSession();
                header('Location: /');
                exit;
            }else{
                // Mauvais mot de passe 
                $_SESSION['error'] = "l'adresse e-mail et/ou le mot de passe est incorrect";
                header('Location: /user/login');
                exit;
            }

       }

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

                /**
                 * Penser à mettre une verification supplementaire 
                 * pour savoir si l'utilisateur est déja inscrit 
                 * ainsi qu'une verif pour savoir si l'username est déja utilisé
                 * et une verif pour un mot de passe plus fort
                 */

                $newUser = new UserModel;
                $newUser->setUsername($username)
                    ->setEmail($email)
                    ->setPassword($passHash);
                
                //On stock l'utilisateur
                $newUser->create();

                $cryptParamURL = Utils::encodeMailURL($email);
                $sendMail = new SendMail;
                $sendMail->sendmailAuth($email, $cryptParamURL);
            }
        }
    }

    /**
     * Déconnexion de l'utilisateur
     *
     * @return void
     */
    public function logout(){
        unset($_SESSION['user']);
        header('Location: /');
        exit;
    }
}