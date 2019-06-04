<?php

namespace App\Controller;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Post;
use App\Filter\PostFilter;
use App\Form\PostFilterType;

class PostsController extends AbstractController
{
    /**
     * @Route("/blog", name="posts.index")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $postFilter = new PostFilter();
        $form = $this->createForm(PostFilterType::class, $postFilter);
        $form->handleRequest($request);

        $posts = $paginator->paginate(
            $this->getDoctrine()->getRepository(Post::class)->findAllPostsQuery($postFilter), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );

        return $this->render('front/posts.html.twig', [
            'posts' => $posts,
            'form' => $form->createView()
        ]);
    }

	/**
	 * @Route("/article/{id}", name="post.show")
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