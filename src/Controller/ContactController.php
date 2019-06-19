<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Contact\Contact;
use App\Form\ContactType;
use App\Services\Mailer;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, Mailer $mailer)
    {
    	$contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $recaptcha = new \ReCaptcha\ReCaptcha('');
            $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
                ->verify($request->get('g-recaptcha-response'), $_SERVER['REMOTE_ADDR']);
            if ($resp->isSuccess()){
                $mailer->sendMessageToAdmin($contact);

                $this->addFlash('success', 'Votre message a bien été envoyée. Nous vous répondrons dans les plus brefs délais.');

                return $this->redirectToRoute('contact');
            }
            else {
                $form->addError(new FormError('Une erreur est survenue avec le reCAPTCHA. Merci de réessayer.'));
            }
        }

        return $this->render('front/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}