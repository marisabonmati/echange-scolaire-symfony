<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    /**
     * @Route("/api/tag", name="api_tag")
     */
    public function apiTag(TagRepository $tagRepository)
    {
        $tags = $tagRepository->find();
        $tagAsArray = array_map(function ($tag){
            return [
                'name' => $tag->getName(),
                'slug' => $tag->getSlug(),
                'id' => $tag->getId()
            ];
        }, $tags);

        return $this->json($tagAsArray);
    }
}
