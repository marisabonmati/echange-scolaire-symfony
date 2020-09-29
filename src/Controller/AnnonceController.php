<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonce", name="annonce")
     */
    public function index()
    {
        return $this->render('annonce/annonce.html.twig', [
            'controller_name' => 'AnnonceController',
        ]);
    }
}
