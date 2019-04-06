<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Post;

class PostsController extends AbstractController
{
    /**
     * @Route("/blog", name="article.index")
     */
    public function index()
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();

        return $this->render('front/posts.html.twig', [
            'posts' => $posts
        ]);
    }

	/**
	 * @Route("/article/{id}", name="article.show")
	 */
    public function show(Post $post)
    {
        if (!$post) {
            throw $this->createNotFoundException('Ce contrat n\'existe pas');
        }

        return $this->render('front/post.html.twig', [
        	'post' => $post
        ]);
    }
}