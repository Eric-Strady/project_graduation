<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\ContractRepository;
use App\Repository\PostRepository;
use App\Repository\AboutRepository;

class AdminHomeController extends AbstractController
{
    private $contractRepository;
    private $postRepository;
    private $aboutRepository;

    public function __construct(ContractRepository $contractRepository, PostRepository $postRepository, AboutRepository $aboutRepository)
    {
        $this->contractRepository = $contractRepository;
        $this->postRepository = $postRepository;
        $this->aboutRepository = $aboutRepository;
    }

	/**
	 * @Route("/admin", name="admin.home")
	 */
    public function index()
    {
        $contracts = $this->contractRepository->findAll();
        $nbContracts = $this->contractRepository->countContracts();
        $nbPosts = $this->postRepository->countPosts();
        $about = $this->aboutRepository->findAbout();
        
        return $this->render('back/admin_home.html.twig', [
            'contracts' => $contracts,
            'nbContracts' => $nbContracts,
            'nbPosts' => $nbPosts,
            'about' => $about
        ]);
    }
}