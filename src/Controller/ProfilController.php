<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Entity\User;
use App\Form\ProfilType;
use App\Form\PublicationType;
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
    public function profilForm(Request $request, EntityManagerInterface $manager, User $modifiedUser)
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

        return $this->render('profil/profil.html.twig', [
            'profilForm' => $profilForm->createView(),
            'user' => $modifiedUser,
        ]);
    }

    /**
     * @Route("/publication/{id}", name="publication")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function publicationForm(Request $request, EntityManagerInterface $manager, Publication $publication)
    {
        $publicationForm = $this->createForm(PublicationType::class, $publication);

        $publicationForm->handleRequest($request);

        if ($publication === null){
            $publication = new Publication();
        }

        if ($publicationForm->isSubmitted() && $publicationForm->isValid()){
            /**
             * @var UploadedFile $pictureFile
             */

            $pictureFile = $publicationForm->get('pictureFile')->getData();

            if ($pictureFile !== null) {
                $filename = md5(uniqid()) . '.' . $pictureFile->guessExtension();
                $pictureFile->move('photo_publi', $filename);
                $publication->setPhoto('photo_publi/'.$filename);
            }

            $publication->setUserPost($this->getUser());

            $manager->persist($publication);
            $manager->flush();

            return $this->redirectToRoute('profil_edit', ['id' => $this -> getUser() -> getId() ]);
        }

        return $this->render('inc/_publication.html.twig', [
            'publicationForm' => $publicationForm->createView(),
        ]);
    }
}
