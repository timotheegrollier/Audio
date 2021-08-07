<?php

namespace App\Controller;

use App\Repository\SoundRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home",methods="GET")
     */
    public function index(SoundRepository $soundRepository): Response
    {
        $lastSounds = $soundRepository->findBy([], ['createdAt' => 'DESC'], 3);

        return $this->render('home/index.html.twig', [
            'sounds' => $lastSounds
        ]);
    }
}