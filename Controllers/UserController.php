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
                $subject = "Authentification de votre profil";
                $message = 'Cliquez sur le lien pour vous authentifier <a href="http://p5blogphp/email/index/'.$cryptParamURL.'"> Valider mon inscription</a>';
                
                $sendMail = new SendMail;
                $sendMail->sendmail($email, $message, $subject);
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

    public function updatePassword(int $id_user)
    {
        $userModel = new UserModel;
        $findUser = $userModel->find($id_user);

        if ($findUser) {
            $form = new Form;
            $form->startForm()
                ->addLabelForm('password', 'Votre ancien mot de passe :')
                ->addInput('password', 'old-password', ['id' => 'password', 'class' => 'validate'])

                ->addLabelForm('password', 'Votre nouveau mot de passe :')
                ->addInput('password', 'new-password', ['id' => 'password', 'class' => 'validate'])

                ->addLabelForm('confirmPassword', ' Confirmer votre Mot de passe :')
                ->addInput('password', 'confirm-password', ['id' => 'confirmPassword', 'class' => 'validate'])

                ->addButton("modifier mon mot de passe", ['class' => 'btn waves-effect waves-light'])
                ->endForm();
            $this->render('/user/updatePassword', ['formUpdatePass' => $form->create()]);  
            
            if (Form::validate($_POST, ['old-password','new-password', 'confirm-password'])) {
                $oldPass = strip_tags($_POST['old-password']);
                $newPass = strip_tags($_POST['new-password']);
                $confirmPass = strip_tags($_POST['confirm-password']);

                $user = $userModel->hydrate($findUser);

                    if (password_verify($oldPass, $user->getPassword())) { 
                        $comparePass = new Utils;
                        $passHash = $comparePass->comparePass($newPass,$confirmPass);

                            if ($passHash === false) {
                                return $passHash;
                            } else {
                                $user->setPassword($passHash);
                                $user->update($findUser->id);
                                $_SESSION['message'] = 'Votre mot de passe a été modifier avec succes';
                            }
                    }
            }
        } else {
            $_SESSION['error'] = "Une erreur est survenue";
            header('Location: /');
            exit;
        }
    }

    public function forgetPassword()
    {
        $form = new Form;
        $form->startForm()
            ->addLabelForm('email', 'E-mail :')
            ->addInput('email', 'email', ['class' => 'validate' , 'id' => 'email'])
            ->addButton("Envoyer", ['class' => 'btn waves-effect waves-light'])
            ->endForm();
        $this->render('/user/forgetPassword', ['formForgetPassword' => $form->create()]); 
        
        if (Form::validate($_POST, ['email'])) { 
            $email = strip_tags($_POST['email']);
            $userModel = new UserModel;
            $foundUser = $userModel->findOneByEmail($email);

                if ($foundUser) {
                    $cryptParamURL = Utils::encodeMailURL($email);
                    $subject = "Authentification de votre profil";
                    $message = 'Cliquez sur le lien pour modifier votre mot de passe <a href="http://p5blogphp/user/updatePassForget/'.$cryptParamURL.'">Lien</a>';
                

                    $sendMail = new SendMail;
                    $sendMail->sendmail($email, $message, $subject);
                }


        }else{
            $_SESSION['error'] = "Une erreur est survenue";
            exit;
        }
    }

    public function updatePassForget(string $cryptParamURL)
    {
        //On decode en base64
        $base64Decode = base64_decode($cryptParamURL);

        //On décrypte le paramètre envoyé dans l'url
        $decryptParamUrl = openssl_decrypt($base64Decode, "AES-128-ECB", getenv('SECRET_KEY_OPENSSL'));

        //On verfie ci l'email correspond a l'email dans la base de donnée
        $userModel = new UserModel;
        $findUser = $userModel->findOneByEmail($decryptParamUrl);

            if ($findUser) {
                
                $form = new Form;
                $form->startForm()
                    ->addLabelForm('password', 'Votre nouveau mot de passe :')
                    ->addInput('password', 'new-password', ['id' => 'password', 'class' => 'validate'])

                    ->addLabelForm('confirmPassword', ' Confirmer votre Mot de passe :')
                    ->addInput('password', 'confirm-password', ['id' => 'confirmPassword', 'class' => 'validate'])

                    ->addButton("modifier mon mot de passe", ['class' => 'btn waves-effect waves-light'])
                    ->endForm();
                $this->render('/user/updatePassForget',['formForgetPassword' => $form->create()]); 
                
                if (Form::validate($_POST, ['new-password', 'confirm-password'])) {
                    $newPass = strip_tags($_POST['new-password']);
                    $confirmPass = strip_tags($_POST['confirm-password']);
    
                    $user = $userModel->hydrate($findUser);

                    $comparePass = new Utils;
                    $passHash = $comparePass->comparePass($newPass,$confirmPass);

                        if ($passHash === false) {
                            return $passHash;
                        } else {
                            $user->setPassword($passHash);
                            $user->update($findUser->id);
                            $_SESSION['message'] = 'Votre mot de passe a été modifier avec succes';
                            header('Location : /user/login');
                        }
                
                }
            }

        
    }
}