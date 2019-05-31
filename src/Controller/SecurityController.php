<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserForgotPasswordType;
use App\Repository\UserRepository;
use App\Security\ForgotPasswordForm;
use App\Services\Mailer;

class SecurityController extends AbstractController
{
    private $em;
    private $repository;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $repository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em = $entityManager;
        $this->repository = $repository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \Exception('Une erreur est survenue lors de la tentative de déconnexion.');
    }

    /**
     * @Route("/mot_de_passe_oublie", name="forgot.password")
     */
    public function forgotPassword(Request $request, TokenGeneratorInterface $tokenGenerator, Mailer $mailer)
    {
        $userEmail = new User();

        $form = $this->createForm(UserType::class, $userEmail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $user = $this->repository->findOneByEmail($userEmail->getEmail());

            if ($user)
            {
                $token_pass = $tokenGenerator->generateToken();
                $user->setTokenPass($token_pass);
                $user->setTokenPassDate(new \DateTime);

                $mailer->sendResetPasswordLink($user);

                $this->em->flush();
                $this->addFlash('success', 'Votre demande de réinitialisation a bien été envoyée. Vérifiez vos e-mails.');

                return $this->redirectToRoute('login');
            }
            else
            {
                $form->addError(new FormError('Cet utilisateur n\'existe pas.'));
            }
        }
        return $this->render('security/forgot_password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/reinitialisation_mot_de_passe/{id}/{token}", name="reset.password")
     */
    public function resetPassword(Request $request, $id, $token)
    {
        $user = $this->repository->find($id);
        if ($user)
        {
            $date = new \DateTime('-30 min');
            if ($this->repository->isTokenDateValid($date))
            {
                if ($user->getTokenPass() === $token)
                {
                    $forgotPassword = new ForgotPasswordForm();

                    $form = $this->createForm(UserForgotPasswordType::class, $forgotPassword);
                    $form->handleRequest($request);

                    if ($form->isSubmitted() && $form->isValid())
                    {
                        $newPassword = $forgotPassword->getNewPassword();
                        $newConfirmPassword = $forgotPassword->getNewConfirmPassword();
                        
                        if ($newPassword === $newConfirmPassword)
                        {
                            $newEncodedPassword = $this->passwordEncoder->encodePassword($user, $newPassword);
                            $user->setPassword($newEncodedPassword);
                            $this->em->flush();

                            $this->addFlash('success', 'Votre mot de passe a bien été réinitialisé.');
                            return $this->redirectToRoute('login');
                        }
                        else 
                        {
                            $form->addError(new FormError('La confirmation du nouveau mot de passe n\'est pas correct.'));
                        }
                    }
                    return $this->render('security/forgot_password_reset.html.twig', [
                        'form' => $form->createView()
                    ]);
                }
            }
            $this->addFlash('error', 'Vous avez dépassé la date de renouvellement de votre mot de passe! Merci de refaire une demande.');
            return $this->redirectToRoute('forgot.password');
        }

        $this->addFlash('error', 'Une erreur est survenue. Merci de réessayer ultérieurement');
        return $this->redirectToRoute('forgot.password');
    }
}