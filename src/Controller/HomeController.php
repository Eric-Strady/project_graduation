<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Contract;

class HomeController extends AbstractController
{
	/**
	 * @Route("/", name="home")
	 */
    public function index()
    {
    	$repository = $this->getDoctrine()->getRepository(Contract::class);

    	$contracts = $repository->findAll();

        return $this->render('pages/home.html.twig', [
        	'contracts' => $contracts
        ]);
    }
}