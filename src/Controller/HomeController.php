<?php

namespace App\Controller;

use App\Repository\PublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(PublicationRepository $publicationRepository)
    {
        $publication = $publicationRepository->searchPublication();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'list_publication' => $publication,

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
