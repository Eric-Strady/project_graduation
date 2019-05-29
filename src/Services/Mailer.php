<?php

namespace App\Services;

use Twig\Environment;

use App\Entity\User;

class Mailer
{
    private $mailer;
    private $environment;

    public function __construct(\Swift_Mailer $mailer, Environment $environment)
    {
        $this->mailer = $mailer;
        $this->environment = $environment;
    }

    public function sendResetPasswordLink(User $user)
    {
        $message = (new \Swift_Message('Réinitialisation mot de passe'))
            ->setFrom('noreply@amap.com')
            ->setTo('prevert@amap.com')
            ->setBody(
                $this->environment->render('security/forgot_password_email.html.twig', [
                    'user' => $user
                ]),
                'text/html'
            );

        $this->mailer->send($message);
    }
}