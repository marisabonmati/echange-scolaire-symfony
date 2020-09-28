<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MentionsAProposController extends AbstractController
{
    /**
     * @Route("/mentions_a_propos", name="mentions/a/propos")
     */
    public function index()
    {
        return $this->render('mentions_a_propos/mentions_a_propos.html.twig', [
            'controller_name' => 'MentionsAProposController',
        ]);
    }
}
