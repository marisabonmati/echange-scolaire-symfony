<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonce/{id}", name="annonce")
     */
    public function index(User $user, Tag  $tag)
    {
        return $this->render('annonce/annonce.html.twig', [
            'user' => $user,
            'tag' => $tag,
        ]);
    }
}