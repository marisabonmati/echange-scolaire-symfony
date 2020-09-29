<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('home/annonce.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/", name="root")
     */
    public function root()
    {
        return $this->redirectToRoute('home');
    }
}
