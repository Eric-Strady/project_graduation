<?php

namespace App\Services;

use Twig\Environment;

use App\Entity\User;
use App\Contact\Contact;
use App\Simulator\Simulator;

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

    public function sendMessageToAdmin(Contact $contact)
    {
        $message = (new \Swift_Message($contact->getSubject()))
            ->setReplyTo($contact->getUserEmail())
            ->setFrom($contact->getUserEmail())
            ->setTo('prevert@amap.com')
            ->setBody(
                $this->environment->render('front/contact/contact_email.html.twig', [
                    'message' => $contact->getMessage()
                ]),
                'text/html'
            );

        $this->mailer->send($message);
    }

    public function sendUserSimulation(Simulator $simulator, $result) {
        $message = (new \Swift_Message('Simulation d\'un abonnement à l\'AMAP'))
            ->setReplyTo($simulator->getEmail())
            ->setFrom($simulator->getEmail())
            ->setTo('prevert@amap.com')
            ->setBody(
                $this->environment->render('front/simulator/simulator_email.html.twig', [
                    'userEmail' => $simulator->getEmail(),
                    'result' => $result
                ]),
                'text/html'
            );

        $this->mailer->send($message);
    }
}