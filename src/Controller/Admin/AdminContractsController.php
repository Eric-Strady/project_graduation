<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\ContractRepository;
use App\Entity\Contract;

class AdminContractsController extends AbstractController
{
	private $repository;

	public function __construct(ContractRepository $repository)
	{
		return $this->repository = $repository;
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
	 * @Route("/admin/contrat/{id}", name="admin.contract.update")
	 */
    public function update(Contract $contract)
    {
    	if (!$contract) {
            throw $this->createNotFoundException('Ce contrat n\'existe pas');
        }

        return $this->render('back/admin_contract.html.twig', [
        	'contract' => $contract
        ]);
    }
}