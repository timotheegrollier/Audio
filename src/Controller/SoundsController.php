<?php

namespace App\Controller;

use App\Entity\Sound;
use App\Repository\SoundRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SoundsController extends AbstractController
{
    /**
     * @Route("/sounds/create", name="app_sounds_create", methods="GET|POST")
     */
    public function index(Request $request, EntityManagerInterface $em, SoundRepository $soundRepository): Response
    {
        $sounds = $soundRepository->findAll();

        $sound = new Sound();
        $form = $this->createFormBuilder($sound, [],)
            ->add('titre', TextType::class, ['attr' => ['placeholder' => 'Name your sound ...']])
            ->add('description', TextareaType::class, ['attr' => ['placeholder' => 'Explain your sound ...']])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($sound);
            $em->flush();
            $this->addFlash('success', 'Votre son à bien été uploadé !');


            return $this->redirectToRoute('app_home');
        }


        return $this->render('sounds/create.html.twig', ['form' => $form->createView(), 'sounds' => $sounds]);
    }
}