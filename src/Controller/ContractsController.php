<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Contract;

class ContractsController extends AbstractController
{
    /**
     * @Route("/contract", name="contract.index")
     */
    public function index()
    {
        $contracts = $this->getDoctrine()->getRepository(Contract::class)->findAll();

        return $this->render('front/contracts.html.twig', [
            'contracts' => $contracts
        ]);
    }

	/**
	 * @Route("/contract/{id}", name="contract.show")
	 */
    public function show(Contract $contract)
    {
        if (!$contract) {
            throw $this->createNotFoundException('Ce contrat n\'existe pas');
        }

        return $this->render('front/contract.html.twig', [
        	'contract' => $contract
        ]);
    }
}