<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SearchType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    /**
     * @Route("/home", name="home")
     */
    public function home(Request $request, UserRepository $userRepository, EntityManagerInterface $manager)
    {

        $searchForm = $this->createForm(SearchType::class);

        return $this->render('home/index.html.twig', [
            'search_form' => $searchForm->createView(),
        ]);
    }

    /**
     * @Route("/search/form", name="search_form")
     */
    public function searchForm(Request $request, UserRepository $userRepository)
    {
        $searchForm = $this->createForm(SearchType::class);

        $searchForm->handleRequest($request);

        if($searchForm->isSubmitted() && $searchForm->isValid()) {
            $data = $searchForm->getData();
            $results = $userRepository->searchSelect($data['language'], $data['options'], $data['entite']);
        }
        return $this->render('search/search.html.twig', [
            'results' => $results
        ]);

    }


}

