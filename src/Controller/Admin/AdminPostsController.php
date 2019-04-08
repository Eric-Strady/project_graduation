<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\PostRepository;

class AdminPostsController extends AbstractController
{
	private $repository;

	public function __construct(PostRepository $repository)
	{
		return $this->repository = $repository;
	}

	/**
	 * @Route("/admin/articles", name="admin.posts")
	 */
    public function index()
    {
    	$posts = $this->repository->findAll();

        return $this->render('back/admin_posts.html.twig', [
        	'posts' => $posts
        ]);
    }
}