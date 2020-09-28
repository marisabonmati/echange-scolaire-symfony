<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil/{id}", name="profil")
     */
    public function index(User $user)
    {
        $profilForm = $this->createForm(ProfilType::class, $user);
        return $this->render('profil/profil.html.twig', [
            'user' => $user,
            'profilForm' => $profilForm->createView(),
        ]);
    }

}
