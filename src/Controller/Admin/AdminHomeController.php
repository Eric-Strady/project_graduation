<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class AdminHomeController extends AbstractController
{
	/**
	 * @Route("/admin", name="admin.home")
	 */
    public function index()
    {
        return $this->render('back/admin_home.html.twig');
    }
}