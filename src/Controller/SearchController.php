<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index()
    {
        return $this->render('search/search.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    /**
     * @Route("/search", name="search")
     */
    public function searchNav(Request $request, UserRepository $userRepository)
    {
       $q = $request->get('search');
      //dd($q);
        $results = $userRepository->searchNav($q);

        return $this->render('search/search.html.twig', [
            'search' => $q,
            'results' => $results
        ]);
    }
}

