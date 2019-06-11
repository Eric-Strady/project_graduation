<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\FoodTypeRepository;
use App\Entity\FoodType;
use App\Form\FoodTypeType;

class AdminFoodTypesController extends AbstractController
{
	private $em;
	private $repository;

	public function __construct(EntityManagerInterface $entityManager, FoodTypeRepository $repository)
	{
		$this->em = $entityManager;
		$this->repository = $repository;
	}

    /**
	 * @Route("/admin/types_alimentation/creer", name="admin.foodtype.create")
	 */
    public function create(Request $request)
    {
    	$foodType = new FoodType();
        
        $form = $this->createForm(FoodTypeType::class, $foodType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
        	$this->em->persist($foodType);
        	$this->em->flush();
        	return $this->redirectToRoute('admin.foodtypes');
        }

        return $this->render('back/admin_foodtype_create.html.twig', [
        	'form' => $form->createView()
        ]);
    }

    /**
	 * @Route("/admin/types_alimentation/modifier/{id}", name="admin.foodtype.update")
	 */
    public function update(FoodType $foodType, Request $request)
    {
    	if (!$foodType) {
            throw $this->createNotFoundException('Ce type d\'alimentation n\'existe pas');
        }

        $form = $this->createForm(FoodTypeType::class, $foodType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
        	$this->em->flush();
        	return $this->redirectToRoute('admin.foodtypes');
        }

        return $this->render('back/admin_foodtype_update.html.twig', [
        	'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/types_alimentation/supprimer/{id}", name="admin.foodtype.delete")
     */
    public function delete(FoodType $foodType, Request $request)
    {
        if (!$foodType) {
            throw $this->createNotFoundException('Ce type d\'alimentation n\'existe pas');
        }

        if ($this->isCsrfTokenValid('delete' . $foodType->getId(), $request->get('_token'))) {
            $this->em->remove($foodType);
            $this->em->flush();
        }
        
        return $this->redirectToRoute('admin.foodtypes');
    }
}