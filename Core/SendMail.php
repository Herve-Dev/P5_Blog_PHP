<?php

namespace App\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class SendMail
{
    public static function sendmail(string $newUserMail, string $message, string $subject)
    {

        $mail = new PHPMailer(true);

        try {
            //configuration
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // je veux des informations de debug

            // On configure le SMTP
            $mail->isSMTP();
            $mail->Host = getenv('HOST_SMTP');
            $mail->SMTPAuth = true;
            $mail->Username = getenv('EMAIL_SMTP');
            $mail->Password = getenv('PASS_SMTP');
            $mail->Port = 1025;

            // Charset
            $mail->CharSet = "utf-8";

            // Destinataires
            $mail->addAddress($newUserMail);

            //Expéditeur
            $mail->setFrom(getenv('EMAIL_SMTP'));

            //Contenu
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
            // On envoie
            $mail->send();
            echo "<script type='text/javascript'>M.toast({html: 'Un lien de vérfication a été envoyé à .'$newUserMail'.'});</script>";
        } catch (Exception) {
            echo "Message non envoyé. Erreur: $mail->ErrorInfo";
        }
    }
}
