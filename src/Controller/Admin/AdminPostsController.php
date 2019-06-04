<?php

namespace App\Controller\Admin;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\PostRepository;
use App\Entity\Post;
use App\Form\PostType;

class AdminPostsController extends AbstractController
{
	private $em;
	private $repository;

	public function __construct(EntityManagerInterface $entityManager, PostRepository $repository)
	{
		$this->em = $entityManager;
		$this->repository = $repository;
	}

	/**
	 * @Route("/admin/articles", name="admin.posts")
	 */
    public function index(PaginatorInterface $paginator, Request $request)
    {
    	$posts = $paginator->paginate(
            $this->getDoctrine()->getRepository(Post::class)->findAllPostsQuery(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );

        return $this->render('back/admin_posts.html.twig', [
        	'posts' => $posts
        ]);
    }

    /**
	 * @Route("/admin/article/creer", name="admin.post.create")
	 */
    public function create(Request $request)
    {
    	$post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
        	$this->em->persist($post);
        	$this->em->flush();
        	return $this->redirectToRoute('admin.posts');
        }

        return $this->render('back/admin_post_create.html.twig', [
        	'form' => $form->createView()
        ]);
    }

    /**
	 * @Route("/admin/article/modifier/{id}", name="admin.post.update")
	 */
    public function update(Post $post, Request $request)
    {
    	if (!$post) {
            throw $this->createNotFoundException('Cet article n\'existe pas');
        }

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $post->setUpdatedAt(new \DateTime());
        	$this->em->flush();
        	return $this->redirectToRoute('admin.posts');
        }

        return $this->render('back/admin_post_update.html.twig', [
        	'form' => $form->createView()
        ]);
    }

    /**
	 * @Route("/admin/article/supprimer/{id}", name="admin.post.delete")
	 */
    public function delete(Post $post, Request $request)
    {
    	if (!$post) {
            throw $this->createNotFoundException('Cet article n\'existe pas');
        }

        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->get('_token'))) {
            $this->em->remove($post);
            $this->em->flush();
        }

        return $this->redirectToRoute('admin.posts');
    }
}