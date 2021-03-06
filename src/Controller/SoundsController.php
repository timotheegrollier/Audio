<?php

namespace App\Controller;

use App\Entity\Sound;
use App\Entity\Type;
use App\Form\EditSoundType;
use App\Repository\SoundRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SoundsController extends AbstractController
{
    /**
     * @Route("/sounds/create", name="app_sounds_create", methods="GET|POST")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {

        // dd($this->getUser());

        if ($this->getUser() === null) {
            $this->addFlash("error", "Vous devez être connécté pour Upload !");
            return $this->redirectToRoute('app_login');
        }

        $sound = new Sound();
        $form = $this->createFormBuilder($sound, ['attr' => ['class' => 'uploadForm']],)
            ->add('soundFile', VichFileType::class, [
                'attr' => ['class' => 'form_soundFile_file'],
                'required' => true,
                'label' => 'Votre son (mp3 / ogg / aac) : ',
                'constraints' => [
                    new File([
                        'maxSize' => '100M',
                        'mimeTypes' => [
                            "audio/mpeg",
                            "audio/ogg",
                            'audio/x-hx-aac-adts',
                            "audio/mp3",
                        ],
                        'mimeTypesMessage' => 'Votre son doit être au format {{ types }}'
                    ]),
                    new NotBlank(['message' => 'Vous devez upload un fichier !'])
                ]
            ])

            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Pas de cover',
                'image_uri' => true,
                'label' => 'Cover image',
                'attr' => ['class' => 'form_imageFile_file'],
            ])

            ->add('titre', TextType::class, ['attr' => ['placeholder' => 'Titre du son ...', 'autocomplete' => 'off']])
            ->add('description', TextareaType::class, ['attr' => ['placeholder' => 'Décrivez votre son ...', 'autocomplete' => 'off']])
            ->add('download', CheckboxType::class, ['label' => 'Autoriser les téléchargements'])
            ->add('type', EntityType::class, ['class' => Type::class, 'choice_label' => 'name'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sound->setUser($this->getUser());
            $em->persist($sound);
            $em->flush();
            $this->addFlash('success', 'Votre son à bien été uploadé !');


            return $this->redirectToRoute('app_home');
        }


        return $this->render('sounds/create.html.twig', ['form' => $form->createView()]);
    }



    /**
     * @Route("/sounds/{id<[0-9]+>}", name="app_listen" ,methods="GET")
     */

    public function listen(Sound $sound): Response
    {
        return $this->render('sounds/listen.html.twig', compact('sound'));
    }




    /**
     * @Route("/sounds/{id<[0-9]+>}/edit", name="app_sounds_edit" ,methods={"GET","PUT"})
     */

    public function edit(Request $request, Sound $sound, EntityManagerInterface $em): Response
    {

        if ($this->getUser() != $sound->getUser()) {
            $this->addFlash('error', 'Vous ne pouvez pas éditer ce son !');
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createForm(EditSoundType::class, $sound, ['method' => 'PUT', 'attr' => ['class' => 'uploadForm']]);
        // dd($sound);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();
            $this->addFlash('success', 'Son édité avec succès');

            return $this->redirectToRoute('app_home');
        }



        return $this->render('sounds/edit.html.twig', ['sound' => $sound, 'form' => $form->createView()]);
    }




    /**
     * @Route("/sounds/list", name="app_sounds_list" ,methods="GET")
     */

    public function list(Request $request, SoundRepository $soundRepository, PaginatorInterface $paginator): Response
    {

        // SEARCH FORM
        $searchForm =  $this->createFormBuilder(null, ['method' => 'GET', 'attr' => ['id' => 'selectType']])
            ->add(
                'type',
                EntityType::class,
                [
                    'class' => Type::class,
                    'choice_label' => 'name',  "required" => false, 'placeholder' => 'Tous types'
                ]
            )
            ->getForm();

        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            return $this->redirectToRoute('app_sounds_search', $request->query->all());
        }



        // ALL SOUNDS & PAGINATION
        $donnees = $soundRepository->findBy([], ["createdAt" => 'DESC']);
        $sounds = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            4
        );
        return $this->render('sounds/list.html.twig', [
            'sounds' => $sounds,
            'search_form' => $searchForm->createView(),
        ]);
    }





    /**
     * @Route("/sounds/{id<[0-9]+>}", name="app_sounds_delete" ,methods="DELETE")
     */

    public function delete(Request $request, Sound $sound, EntityManagerInterface $em): Response
    {
        if ($this->getUser() != $sound->getUser()) {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer ce son !');
            return $this->redirectToRoute('app_home');
        }

        if ($this->isCsrfTokenValid('sound_delete', $request->request->get('csrf_token'))) {
            $em->remove($sound);
            $em->flush();

            $this->addFlash('info', 'Votre son à été supprimé !');
        }

        return $this->redirectToRoute('app_home');
    }
}