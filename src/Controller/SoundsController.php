<?php

namespace App\Controller;

use App\Entity\Sound;
use App\Repository\SoundRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Form\Type\VichImageType;
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
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Pas de cover',
                'image_uri' => true,
                'label' => 'Cover'
            ])
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



    /**
     * @Route("/sounds/{id<[0-9]+>}", name="app_listen" ,methods="GET")
     */

    public function show(Sound $sounds): Response
    {
        return $this->render('sounds/show.html.twig', compact('sounds'));
    }
}