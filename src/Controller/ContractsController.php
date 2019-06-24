<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Contract;

class ContractsController extends AbstractController
{
    /**
     * @Route("/contrats", name="contracts.index")
     */
    public function index()
    {
        $contracts = $this->getDoctrine()->getRepository(Contract::class)->findAll();

        return $this->render('front/contracts/contracts.html.twig', [
            'contracts' => $contracts
        ]);
    }

	/**
	 * @Route("/contrat/{id}", name="contract.show")
	 */
    public function show(Contract $contract)
    {
        if (!$contract) {
            throw $this->createNotFoundException('Ce contrat n\'existe pas');
        }

        return $this->render('front/contracts/contract.html.twig', [
        	'contract' => $contract
        ]);
    }
}