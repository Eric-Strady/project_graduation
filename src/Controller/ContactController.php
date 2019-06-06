<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
            $mailer->sendMessageToAdmin($contact);

            $this->addFlash('success', 'Votre message a bien été envoyée. Nous vous répondrons dans les plus brefs délais.');

            return $this->redirectToRoute('contact');
        }

        return $this->render('front/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}