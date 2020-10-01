<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonce/{id}", name="annonce")
     */
    public function index(User $user, PublicationRepository $publicationRepository)
    {
        $publication = $publicationRepository->searchPublication();
        return $this->render('annonce/annonce.html.twig', [
            'user' => $user,
            'list_publication' => $publicationRepository,
        ]);
    }
}
