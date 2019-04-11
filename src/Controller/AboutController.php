<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\About;

class AboutController extends AbstractController
{
    /**
     * @Route("/à-propos", name="about")
     */
    public function index()
    {
    	$about = $this->getDoctrine()->getRepository(About::class)->findAbout();

        return $this->render('front/about.html.twig', [
        	'about' => $about
        ]);
    }
}