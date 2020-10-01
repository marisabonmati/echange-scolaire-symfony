<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PublicationRepository;
use App\Form\AffinerRechercheType;
use App\Form\RechercheType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="root")
     */
    public function root()
    {
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/home", name="home")
     */
    public function home(UserRepository $userRepository, PublicationRepository $publicationRepository)
    {   // CETTE FONCTION PERMET D'AFFICHER LE FORMULAIRE DE RECHERCHE DE LA PAGE HOME
        $searchForm = $this->createForm(RechercheType::class);
        $publication = $publicationRepository->searchPublication();

        return $this->render('home/index.html.twig', [
            'search_form' => $searchForm->createView(),
            'list_publication' => $publication,
        ]);
    }

    /**
     * @Route("/search/form", name="search_form")
     */
    public function searchForm(Request $request, UserRepository $userRepository)
    {   //CETTE FONCTION PERMET DE TRAITER LES REQUETES DE LA PAGE HOME + PAGE SEARCH
        if($request->getMethod()!='POST'){
            return $this->redirectToRoute('home');
        }
            $searchForm = $this->createForm(RechercheType::class);
            $affinerForm = $this->createForm(AffinerRechercheType::class);

            $searchForm->handleRequest($request);
            $affinerForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $data = $searchForm->getData();
            $results = $userRepository->searchSelect($data['Langue'], $data['Options'], $data['Entite']);
        } else if ($affinerForm->isSubmitted() && $affinerForm->isValid()) {
            $data = $affinerForm->getData();
            $results = $userRepository->AffinerRechercheSelect($data['Langue'], $data['options'], $data['level'], $data['country'], $data['capacity']);
        }
        return $this->render('search/search.html.twig', [
            'results' => $results,
            'affiner_form' => $affinerForm->createView()
        ]);

    }


}
