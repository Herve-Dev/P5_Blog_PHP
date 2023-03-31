<?php
namespace App\Utils;

class Utils
{
    /**
     * Fontion pour Hash le mot de passe
     *
     * @param string $pass
     * @param string $confirmPass
     * @return string
     */
    public function comparePass(string $pass, string $confirmPass)
    {
        if ($pass === $confirmPass) {
            $pass = password_hash($pass, PASSWORD_ARGON2I);
            return $pass;
        }
        echo "<script type='text/javascript'>M.toast({html: 'Mot de passe différent'});</script>";
        return false;
    }

    /**
     * Fonction pour passer paramètre dans URL de verification utilisateur
     *
     * @return string
     */
    public static function encodeMailURL(string $email) 
    {
        //PENSEZ A METTRE UN TEMPS LIMITE POUR VALIDATION DU LIEN
        $cryptParamUrl = openssl_encrypt($email,"AES-128-ECB", getenv('SECRET_KEY_OPENSSL'));
        $base64Email = base64_encode($cryptParamUrl);
        return $base64Email;
    }
}