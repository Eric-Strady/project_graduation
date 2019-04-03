<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Contract;

class ContractController extends AbstractController
{
	/**
	 * @Route("/contract/{id}", name="contract")
	 */
    public function index(Contract $contract)
    {
        if (!$contract) {
            throw $this->createNotFoundException('Ce contrat n\'existe pas');
        }

        return $this->render('pages/contract.html.twig', [
        	'contract' => $contract
        ]);
    }
}