<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="app_user_account")
     */
    public function userAccount(): Response
    {
        return $this->render('account/user_account.html.twig');
    }


    /**
     * @Route("/account/edit", name="app_account_edit")
     */
    public function accountEdit(EntityManagerInterface $em, Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createFormBuilder($user)
            ->add('name', TextType::class, ['label' => 'Pseudo', 'attr' => ['autocomplete' => 'disabled']])
            ->add('email', EmailType::class)
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => "J'ai lu et j'accepte les conditons d'utilisations",
                'constraints' => [
                    new IsTrue([
                        'message' => "Vous devez acceptez les conditions d'utilisation !",
                    ]),
                ],
            ])
            ->add('Modifier', SubmitType::class, ['attr' => ['formnovalidate' => 'formnovalidate']])

            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();
            $this->addFlash('success', 'Compte modifié avec succès');

            return $this->redirectToRoute('app_home');
        }
        return $this->render('account/account_edit.html.twig', ['form' => $form->createView()]);
    }
}