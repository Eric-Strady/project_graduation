<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class AboutController extends AbstractController
{
    /**
     * @Route("/à-propos", name="about")
     */
    public function index()
    {
        return $this->render('front/about.html.twig');
    }
}