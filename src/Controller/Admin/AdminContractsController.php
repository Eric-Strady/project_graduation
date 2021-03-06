<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Contract;
use App\Entity\FoodType;
use App\Entity\Grower;
use App\Entity\Product;
use App\Form\ContractType;
use App\Repository\ContractRepository;

class AdminContractsController extends AbstractController
{
	private $em;
	private $repository;

	public function __construct(EntityManagerInterface $entityManager, ContractRepository $repository)
	{
		$this->em = $entityManager;
		$this->repository = $repository;
	}

	/**
	 * @Route("/admin/contrats", name="admin.contracts")
	 */
    public function index()
    {
    	$contracts = $this->repository->findAll();

        return $this->render('back/admin_contracts/admin_contracts.html.twig', [
        	'contracts' => $contracts
        ]);
    }

    /**
	 * @Route("/admin/contrat/creer", name="admin.contract.create")
	 */
    public function create(Request $request)
    {
    	$contract = new Contract();
        
        $form = $this->createForm(ContractType::class, $contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            foreach ($contract->getProducts() as $product)
            {
                $product->setContract($contract);
                $this->em->persist($product);
            }
        	$this->em->persist($contract);
        	$this->em->flush();
        	return $this->redirectToRoute('admin.contracts');
        }

        return $this->render('back/admin_contracts/admin_contract_create.html.twig', [
        	'form' => $form->createView()
        ]);
    }

    /**
	 * @Route("/admin/contrat/modifier/{id}", name="admin.contract.update")
	 */
    public function update(Contract $contract, Request $request)
    {
    	if (!$contract) {
            throw $this->createNotFoundException('Ce contrat n\'existe pas');
        }

        $form = $this->createForm(ContractType::class, $contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            foreach ($contract->getProducts() as $product)
            {
                $product->setContract($contract);
                $this->em->persist($product);
            }
        	$this->em->flush();
        	return $this->redirectToRoute('admin.contracts');
        }

        return $this->render('back/admin_contracts/admin_contract_update.html.twig', [
        	'form' => $form->createView()
        ]);
    }

    /**
	 * @Route("/admin/contrat/supprimer/{id}", name="admin.contract.delete")
	 */
    public function delete(Contract $contract, Request $request)
    {
        if (!$contract) {
            throw $this->createNotFoundException('Ce contrat n\'existe pas');
        }

        if ($this->isCsrfTokenValid('delete' . $contract->getId(), $request->get('_token'))) {
            $this->em->remove($contract);
            $this->em->flush();
        }
    	
        return $this->redirectToRoute('admin.contracts');
    }

    /**
     * @Route("/admin/parametres_formulaire", name="admin.contract.form.param")
     */
    public function formParam()
    {
        $foodTypes = $this->getDoctrine()->getRepository(FoodType::class)->findAll();
        $growers = $this->getDoctrine()->getRepository(Grower::class)->findAll();

        return $this->render('back/admin_contracts/admin_contract_form_param.html.twig', [
            'foodTypes' => $foodTypes,
            'growers' => $growers
        ]);
    }
}