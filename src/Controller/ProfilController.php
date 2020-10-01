<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Entity\User;
use App\Form\ProfilType;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil/{id}", name="profil_edit")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Security("user === null or modifiedUser == user")
     */
    public function profilForm(Request $request, EntityManagerInterface $manager, User $modifiedUser, PublicationRepository $publicationRepository)
    {

        $profilForm = $this->createForm(ProfilType::class, $modifiedUser);

        $profilForm->handleRequest($request);

        if($profilForm->isSubmitted() && $profilForm->isValid()){

            /**
             * @var UploadedFile $photoFile
             */

            $photoFile = $profilForm->get('photoFile')->getData();

            if ($photoFile !== null) {
                $filename = md5(uniqid()) . '.' . $photoFile->guessExtension();
                $photoFile->move('photo_user', $filename);
                $modifiedUser->setPhoto('photo_user/'.$filename);
            }

            $manager->persist($modifiedUser);
            $manager->flush();
        }

        $publi = $publicationRepository->searchPublication();

        return $this->render('profil/profil.html.twig', [
            'profilForm' => $profilForm->createView(),
            'user' => $modifiedUser,
            'list_publication' => $publi,
        ]);
    }

    /**
     * @Route("/publication", name="publication")
     * @Route("/publication/edit/{id}", name="publication_edit")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function publicationForm(Request $request, EntityManagerInterface $manager, Publication $publication = null)
    {
        if ($publication === null){
            $publication = new Publication();
        }

        $publicationForm = $this->createForm(PublicationType::class, $publication);

        $publicationForm->handleRequest($request);

        if ($publicationForm->isSubmitted() && $publicationForm->isValid()){
            /**
             * @var UploadedFile $pictureFile
             */

            $pictureFile = $publicationForm->get('pictureFile')->getData();

            if ($pictureFile !== null) {
                $filename = md5(uniqid()) . '.' . $pictureFile->guessExtension();
                $pictureFile->move('photo_publi', $filename);
                $publication->setPicture('photo_publi/'.$filename);
            }

            $publication->setUserPost($this->getUser());

            $manager->persist($publication);
            $manager->flush();

            return $this->redirectToRoute('profil_edit', ['id' => $this -> getUser() -> getId() ]);
        }

        return $this->render('form/publicationForm.html.twig', [
            'publicationForm' => $publicationForm->createView(),
        ]);
    }
}
