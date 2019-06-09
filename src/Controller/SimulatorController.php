<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Form\SimulatorType;
use App\Simulator\Simulator;

class SimulatorController extends AbstractController
{
    /**
     * @Route("/simulateur", name="simulator")
     */
    public function index(Request $request)
    {
    	$simulator = new Simulator();
    	$form = $this->createForm(SimulatorType::class, $simulator);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            return $this->redirectToRoute('contact');
        }
        return $this->render('front/simulator.html.twig', [
            'form' => $form->createView()
        ]);
    }
}