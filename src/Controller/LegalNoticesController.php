<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class LegalNoticesController extends AbstractController
{
	/**
	 * @Route("/mentions_legales", name="legal.notices")
	 */
    public function showLegalNotices()
    {
        return $this->render('front/legal_notices.html.twig');
    }
}