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


        // FOR REMEMBER ME FEATURE
        if (isset($_COOKIE['rem'])) {
            if ($_COOKIE['rem'] == 1) {
                session_start();
                session_abort();
                session_set_cookie_params(26280028);
                unset($_COOKIE['rem']);
                setcookie('rem', '', time() - 3600, '/');
            }
        }


        $lastSounds = $soundRepository->findBy([], ['createdAt' => 'DESC'], 3);

        return $this->render('home/index.html.twig', [
            'sounds' => $lastSounds
        ]);
    }
}