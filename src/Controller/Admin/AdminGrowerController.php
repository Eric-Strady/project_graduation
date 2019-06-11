<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Grower;
use App\Form\GrowerType;
use App\Repository\GrowerRepository;

class AdminGrowerController extends AbstractController
{
	private $em;
	private $repository;

	public function __construct(EntityManagerInterface $entityManager, GrowerRepository $repository)
	{
		$this->em = $entityManager;
		$this->repository = $repository;
	}

    /**
	 * @Route("/admin/producteur/creer", name="admin.grower.create")
	 */
    public function create(Request $request)
    {
    	$grower = new Grower();
        
        $form = $this->createForm(GrowerType::class, $grower);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
        	$this->em->persist($grower);
        	$this->em->flush();
        	return $this->redirectToRoute('admin.contract.form.param');
        }

        return $this->render('back/admin_grower_create.html.twig', [
        	'form' => $form->createView()
        ]);
    }

    /**
	 * @Route("/admin/producteur/modifier/{id}", name="admin.grower.update")
	 */
    public function update(Grower $grower, Request $request)
    {
    	if (!$grower) {
            throw $this->createNotFoundException('Ce producteur n\'existe pas');
        }

        $form = $this->createForm(GrowerType::class, $grower);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
        	$this->em->flush();
        	return $this->redirectToRoute('admin.contract.form.param');
        }

        return $this->render('back/admin_grower_update.html.twig', [
        	'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/producteur/supprimer/{id}", name="admin.grower.delete")
     */
    public function delete(Grower $grower, Request $request)
    {
        if (!$grower) {
            throw $this->createNotFoundException('Ce producteur n\'existe pas');
        }

        if ($this->isCsrfTokenValid('delete' . $grower->getId(), $request->get('_token'))) {
            $this->em->remove($grower);
            $this->em->flush();
        }
        
        return $this->redirectToRoute('admin.contract.form.param');
    }
}