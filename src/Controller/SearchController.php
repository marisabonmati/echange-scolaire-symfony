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
    {
        $affinerForm = $this->createForm(AffinerRechercheType::class);
       $q = $request->get('search');
      //dd($q);
        $results = $userRepository->searchNav($q);

        return $this->render('search/search.html.twig', [
            'search' => $q,
            'results' => $results,
            'affiner_form' => $affinerForm->createView()
        ]);
    }

    /**
     * @Route("/search/affiner", name="search_affiner")
     */
    public function AffinerRechercheForm(Request $request, UserRepository $userRepository)
    {
        $affinerForm = $this->createForm(AffinerRechercheType::class);

        $affinerForm->handleRequest($request);

        if($affinerForm->isSubmitted() && $affinerForm->isValid()) {
            $data = $affinerForm->getData();
            $results = $userRepository->AffinerRechercheSelect($data['Langue'], $data['options'], $data['level'], $data['capacity'], $data['country']);
        }

        return $this->render('search/search.html.twig', [
            'results' => $results
        ]);

    }

}

