<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilType;
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
}
