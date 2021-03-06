<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    /**
     * @Route("/api/tag", name="api_tag")
     */
    public function apiTag(TagRepository $tagRepository, Request $request, EntityManagerInterface $manager)
    {
        $q = $request->get('q');

        $results = $tagRepository->apiTag($q);

        $tagAsArray = array_map(function ($tag){
            return [
                'text' => $tag->getName(),
                'id' => $tag->getId(),
            ];
        }, $results);

        return $this->json($tagAsArray);
    }
}
