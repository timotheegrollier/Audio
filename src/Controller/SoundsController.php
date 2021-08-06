<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SoundsController extends AbstractController
{
    /**
     * @Route("/sounds/create", name="app_sounds_create", methods="GET|POST")
     */
    public function index(): Response
    {
        return $this->render('sounds/index.html.twig', [
            'controller_name' => 'SoundsController',
        ]);
    }
}