<?php

namespace App\Controllers;

use App\Core\Form;
use App\Core\SendMail;

class ContactController extends Controller
{
    public function sendMailContact()
    {
        $form = new Form;
        $form->startForm()
            ->addLabelForm('email', 'E-mail :')
            ->addInput('email', 'email', ['class' => 'validate', 'id' => 'email'])
            ->addLabelForm('message', 'Votre message :')
            ->addTextarea('message', ['class' => 'materialize-textarea', 'id' => 'textarea-contact'])
            ->addButton("Envoyer", ['class' => 'btn waves-effect waves-light'])
            ->endForm();

        $this->render('/contact/contact', ['formMail' => $form->create()]);

        if (Form::validate($_POST, ['email', 'message'])) {
            $message = strip_tags($_POST['message']);
            $emailUser = strip_tags($_POST['email']);
            $email = getenv('EMAIL_SMTP');

            $subject = "Message de : $emailUser";
            $sendMail = new SendMail;
            $sendMail->sendmail($email, $message, $subject);

            echo "<div class='bloc-msg-good'> Votre message a été envoyé avec succes </div>";
            header("refresh:2; /");
        } else {
            echo "<div class='bloc-msg-bad'> une erreur est survenue </div>";
            header("refresh:2; /");
        }
    }
}
