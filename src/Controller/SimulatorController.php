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
use App\Entity\FoodType;
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
            $recaptcha = new \ReCaptcha\ReCaptcha('');
            $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
                ->verify($request->get('g-recaptcha-response'), $_SERVER['REMOTE_ADDR']);
            if ($resp->isSuccess()){
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
            else {
                $this->addFlash('error', 'Une erreur est survenue avec le reCAPTCHA. Merci de réessayer.');
                return $this->redirectToRoute('simulator');
            }
        }

        return $this->render('front/simulator/simulator.html.twig', [
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
            $selectedFoodTypes = $request->get('selectedFoodTypes');
            $choices = $request->get('choices');

            $about = $this->getDoctrine()->getRepository(About::class)->findAbout();
            $annualMembershipFee = $about->getAnnualMembershipFee();
            $totalPrice = $annualMembershipFee;

            $foodTypes = [];
            $products = [];
            $isFoodTypesValid = true;
            $isProductsValid = true;

            if ($selectedFoodTypes) {
                foreach ($selectedFoodTypes as $value) {
                    $foodType = $this->getDoctrine()->getRepository(FoodType::class)->find($value);
                    if ($foodType) {
                        array_push($foodTypes, $foodType->getName());
                    }
                    else {
                        $isFoodTypesValid = false;
                    }
                }
            }
            else {
                $isFoodTypesValid = false;
            }

            if ($choices) {
                foreach ($choices as $value) {
                    $product = $this->getDoctrine()->getRepository(Product::class)->find($value);
                    if ($product) {
                        $price = $calculatePrice->definePrice($nbChild, $nbAdult, $product);
                        $totalPrice += $price;
                        array_push($products, $product->getName());
                    }
                    else {
                        $isProductsValid = false;
                    }
                }
            }

            $simulatorData = [
                'nbChild' => $nbChild,
                'nbAdult' => $nbAdult,
                'foodTypes' => $foodTypes,
                'totalPrice' => $totalPrice,
                'products' => $products
            ];
            $_SESSION['simulatorData'] = $simulatorData;
            
            $returnedData = [
                'isFoodTypesValid' => $isFoodTypesValid,
                'isProductsValid' => $isProductsValid,
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