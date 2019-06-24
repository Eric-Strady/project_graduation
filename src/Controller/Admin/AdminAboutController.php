<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\AboutRepository;
use App\Entity\About;
use App\Form\AboutType;

class AdminAboutController extends AbstractController
{
    private $em;
    private $repository;

    public function __construct(AboutRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->repository = $repository;
    }

	/**
	 * @Route("/admin/a-propos/modifier", name="admin.about")
	 */
    public function update(Request $request)
    {
        $about = $this->getDoctrine()->getRepository(About::class)->findAbout();
        
        $form = $this->createForm(AboutType::class, $about);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            return $this->redirectToRoute('admin.home');
        }

        return $this->render('back/admin_about/admin_about_update.html.twig', [
            'form' => $form->createView()
        ]);
    }
}