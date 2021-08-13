<?php

namespace App\Controller;

use App\Entity\Type;
use App\Repository\SoundRepository;
use App\Repository\TypeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
    /**
     * @Route("sounds/search/", name="app_sounds_search" , methods="GET")
     */
    public function search(Request $request, SoundRepository $soundRepository, PaginatorInterface $paginator): Response
    {
        // SearchForm pour le repasser à la vue
        $searchForm =  $this->createFormBuilder(null, ['method' => 'GET', 'attr' => ['id' => 'selectType']])
            ->add('type', EntityType::class, ['class' => Type::class, 'choice_label' => 'name', "required" => false, 'empty_data' => '', 'placeholder' => 'Tous types'])
            ->getForm();
        $searchForm->handleRequest($request);

        // Je récupère l'id de la catégory depuis la requête GET (query) transféré depuis la Liste
        // dd($request->query->get('form')['type']);

        $soundTypeId = $request->query->get('form')['type'];
        // Si l'id n'est pas vide on affiche tout les sons de ce type sinon on affiche tout les sons 
        if ($soundTypeId != "") {
            $soundType = strip_tags(htmlspecialchars($soundTypeId));
            $donnees = $soundRepository->findBy(['type' => $soundType], ["createdAt" => 'DESC']);
            $sounds = $paginator->paginate(
                $donnees,
                $request->query->getInt('page', 1),
                4
            );
        } else {
            $donnees = $soundRepository->findBy([], ["createdAt" => 'DESC']);
            $sounds = $paginator->paginate(
                $donnees,
                $request->query->getInt('page', 1),
                4
            );
        }
        return $this->render('sounds/list.html.twig', [
            'sounds' => $sounds,
            'search_form' => $searchForm->createView(),
        ]);
    }
}