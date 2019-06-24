<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Form\UserResetEmailType;
use App\Form\UserResetPasswordType;
use App\Security\ResetEmailForm;
use App\Security\ResetPasswordForm;

class AdminAccountController extends AbstractController
{
    private $em;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/admin/compte/changer_identifiant", name="admin.account.reset.email")
     */
    public function resetEmail(Request $request)
    {
        $resetEmail = new ResetEmailForm();
        $user = $this->getUser();
        $formResetEmail = $this->createForm(UserResetEmailType::class, $resetEmail);
 
        $formResetEmail->handleRequest($request);
        if ($formResetEmail->isSubmitted() && $formResetEmail->isValid())
        {
            $newEmail = $resetEmail->getNewEmail();
            $user->setEmail($newEmail);
            $this->em->flush();

            return $this->redirectToRoute('admin.home');
        }

        return $this->render('back/admin_account/admin_account_reset_email.html.twig', [
            'formResetEmail' => $formResetEmail->createView(),
        ]);
    }

    /**
     * @Route("/admin/compte/changer_mot_de_passe", name="admin.account.reset.password")
     */
    public function resetPassword(Request $request)
    {
        $resetPassword = new ResetPasswordForm();
        $user = $this->getUser();
        $formResetPassword = $this->createForm(UserResetPasswordType::class, $resetPassword);

        $formResetPassword->handleRequest($request);
        if ($formResetPassword->isSubmitted() && $formResetPassword->isValid())
        {
            $newPassword = $resetPassword->getNewPassword();
            $newConfirmPassword = $resetPassword->getNewConfirmPassword();
            
            if ($newPassword === $newConfirmPassword)
            {
                $newEncodedPassword = $this->passwordEncoder->encodePassword($user, $newPassword);
                $user->setPassword($newEncodedPassword);
                $this->em->flush();

                return $this->redirectToRoute('admin.home');
            }
            else 
            {
                $formResetPassword->addError(new FormError('La confirmation du nouveau mot de passe n\'est pas correct.'));
            }
        }

        return $this->render('back/admin_account/admin_account_reset_password.html.twig', [
            'formResetPassword' => $formResetPassword->createView()
        ]);
    }
}