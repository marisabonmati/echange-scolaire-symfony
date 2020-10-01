<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AffinerRechercheType;
use App\Form\RechercheType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{

    /**
     * @Route("/search/nav", name="search_nav")
     */
    public function searchNav(Request $request, UserRepository $userRepository)
    {   //CETTE FONCTION PERMET DE TRAITER LA REQUETE DE LA BARRE DE RECHERCHE SUR LE HEADER
            $affinerForm = $this->createForm(AffinerRechercheType::class);
            $q = $request->get('search');
            $results = $userRepository->searchNav($q);

        return $this->render('search/search.html.twig', [
            'search' => $q,
            'results' => $results,
            'affiner_form' => $affinerForm->createView()
        ]);
    }
}

