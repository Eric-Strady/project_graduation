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
use App\Services\Mailer;
use App\Simulator\Simulator;
use App\Simulator\CalculatePrice;

class SimulatorController extends AbstractController
{
    /**
     * @Route("/simulateur", name="simulator")
     */
    public function index(Request $request, Mailer $mailer)
    {
        $contracts = $this->getDoctrine()->getRepository(Contract::class)->findAll();

    	$simulator = new Simulator();
    	$form = $this->createForm(SimulatorType::class, $simulator);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            if ($_SESSION['simulatorData']) {
                $result = $_SESSION['simulatorData'];
                $mailer->sendUserSimulation($simulator, $result);

                $this->addFlash('success', 'Votre simulation a bien été envoyée! Vous serez recontacté prochainement.');
                return $this->redirectToRoute('simulator');
            }
            else {
                $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi de votre simulation, merci de réessayer.');
                return $this->redirectToRoute('simulator');
            }
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
            $foodType = $request->get('foodType');
            $choices = $request->get('choices');

            $about = $this->getDoctrine()->getRepository(About::class)->findAbout();
            $annualMembershipFee = $about->getAnnualMembershipFee();
            $totalPrice = $annualMembershipFee;

            $products = [];
            $isValid = true;
            if ($choices) {
                foreach ($choices as $value) {
                    $product = $this->getDoctrine()->getRepository(Product::class)->find($value);
                    if ($product)
                    {
                        $price = $calculatePrice->definePrice($nbChild, $nbAdult, $product);
                        $totalPrice += $price;
                        array_push($products, $product->getName());
                    }
                    else
                    {
                        $isValid = false;
                    }
                }
            }

            $simulatorData = [
                'nbChild' => $nbChild,
                'nbAdult' => $nbAdult,
                'foodType' => $foodType,
                'totalPrice' => $totalPrice,
                'products' => $products
            ];
            $_SESSION['simulatorData'] = $simulatorData;
            
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