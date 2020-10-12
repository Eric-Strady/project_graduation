<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\About;
use App\Repository\AboutRepository;
use App\Repository\ContractRepository;

class AboutController extends AbstractController
{
    private $aboutRepository;
    private $contractRepository;

    public function __construct(AboutRepository $aboutRepository, ContractRepository $contractRepository)
    {
        $this->aboutRepository = $aboutRepository;
        $this->contractRepository = $contractRepository;
    }

    /**
     * @Route("/a-propos", name="about")
     */
    public function index()
    {
    	$about = $this->getDoctrine()->getRepository(About::class)->findAbout();
        $nbContracts = $this->contractRepository->countContracts();

        return $this->render('front/about/about.html.twig', [
        	'about' => $about,
            'nbContracts' => $nbContracts
        ]);
    }
}