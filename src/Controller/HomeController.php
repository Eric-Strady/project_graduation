<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Contract;
use App\Entity\Post;

class HomeController extends AbstractController
{
	/**
	 * @Route("/", name="home")
	 */
    public function index()
    {
    	$contracts = $this->getDoctrine()->getRepository(Contract::class)->findAll();
    	$lastPosts = $this->getDoctrine()->getRepository(Post::class)->findLastPosts();

        return $this->render('pages/home.html.twig', [
        	'contracts' => $contracts,
        	'lastPosts' => $lastPosts
        ]);
    }
}