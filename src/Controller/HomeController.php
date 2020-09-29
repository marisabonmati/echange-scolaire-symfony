<?php

namespace App\Controller;

use App\Form\RechercheType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
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

    /**
     * @Route("/search/form", name="search_form")
     */
    public function searchForm(Request $request, UserRepository $userRepository)
    {
        $searchForm = $this->createForm(RechercheType::class);

        $searchForm->handleRequest($request);

        if($searchForm->isSubmitted() && $searchForm->isValid()) {
            $data = $searchForm->getData();
            $results = $userRepository->searchSelect($data['Langue'], $data['Options'], $data['Entite']);
        }
        return $this->render('search/search.html.twig', [
            'results' => $results
        ]);

    }

}
