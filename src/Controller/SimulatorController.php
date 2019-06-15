<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use App\Entity\About;
use App\Entity\Contract;
use App\Entity\Product;
use App\Form\SimulatorType;
use App\Simulator\Simulator;
use App\Simulator\CalculatePrice;

class SimulatorController extends AbstractController
{
    /**
     * @Route("/simulateur", name="simulator")
     */
    public function index(Request $request)
    {
        $contracts = $this->getDoctrine()->getRepository(Contract::class)->findAll();

    	$simulator = new Simulator();
    	$form = $this->createForm(SimulatorType::class, $simulator);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            return $this->redirectToRoute('contact');
        }

        return $this->render('front/simulator.html.twig', [
            'form' => $form->createView(),
            'contracts' => $contracts
        ]);
    }

    /**
     * @Route("/simulateur/calcul", name="simulator.calculate")
     */
    public function calculatePrice(Request $request, CalculatePrice $calculatePrice) {
        if ($request->isXMLHttpRequest())
        {
            $encoders = [new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];
            $serializer = new Serializer($normalizers, $encoders);

            $nbChild = $request->get('nbChild');
            $nbAdult = $request->get('nbAdult');
            $choices = $request->get('choices');

            $about = $this->getDoctrine()->getRepository(About::class)->findAbout();
            $annualMembershipFee = $about->getAnnualMembershipFee();
            $totalPrice = $annualMembershipFee;

            $isValid = true;

            if ($choices) {
                foreach ($choices as $value) {
                    $product = $this->getDoctrine()->getRepository(Product::class)->find($value);
                    if ($product)
                    {
                        $isVariableDelivery = $product->getIsVariableDelivery();
                        $nbDelivery = $product->getNbDelivery();
                        $isFixedPrice = $product->getIsFixedPrice();
                        $fixedPrice = $product->getFixedPrice();
                        $minPrice = $product->getMinPrice();
                        $maxPrice = $product->getMaxPrice();

                        $price = $calculatePrice->definePrice($nbChild, $nbAdult, $isVariableDelivery, $nbDelivery, $isFixedPrice, $fixedPrice, $minPrice, $maxPrice);
                        $totalPrice += $price;
                    }
                    else
                    {
                        $isValid = false;
                    }
                }
            }
            
            $returnedData = [
                'isValid' => $isValid,
                'totalPrice' => $totalPrice
            ];
            $result = $serializer->serialize($returnedData, 'json');
            
            return $this->json($result, 200);
        }
        else
        {
            return $this->redirectToRoute('simulator');
        }
    }
}