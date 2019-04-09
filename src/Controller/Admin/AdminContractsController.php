<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\ContractRepository;
use App\Entity\Contract;
use App\Form\ContractType;

class AdminContractsController extends AbstractController
{
	private $em;
	private $repository;

	public function __construct(ContractRepository $repository, EntityManagerInterface $entityManager)
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

        return $this->render('back/admin_contracts.html.twig', [
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
        	$this->em->persist($contract);
        	$this->em->flush();
        	return $this->redirectToRoute('admin.contracts');
        }

        return $this->render('back/admin_contract_create.html.twig', [
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
        	$this->em->flush();
        	return $this->redirectToRoute('admin.contracts');
        }

        return $this->render('back/admin_contract_update.html.twig', [
        	'form' => $form->createView()
        ]);
    }

    /**
	 * @Route("/admin/contrat/supprimer/{id}", name="admin.contract.delete")
	 */
    public function delete(Contract $contract)
    {
    	if (!$contract) {
            throw $this->createNotFoundException('Ce contrat n\'existe pas');
        }

        $this->em->remove($contract);
        $this->em->flush();

        return $this->redirectToRoute('admin.contracts');
    }
}