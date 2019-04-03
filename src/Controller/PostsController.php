<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Post;

class PostsController extends AbstractController
{
	/**
	 * @Route("/article/{id}", name="article.show")
	 */
    public function show(Post $post)
    {
        if (!$post) {
            throw $this->createNotFoundException('Ce contrat n\'existe pas');
        }

        return $this->render('pages/post.html.twig', [
        	'post' => $post
        ]);
    }
}