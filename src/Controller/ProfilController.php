<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\User;

use App\Form\ProfilType;
use App\Repository\UserRepository;
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
     * @Route("/profil/{id}", name="profil")
     */
    public function index(User $user)
    {
        return $this->render('profil/profil.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/profil/edit/{id}", name="profil_edit")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Security("user === null or user.getUser() == user")
     */
    public function profilForm(Request $request, EntityManagerInterface $manager, User $user = null, Tag $tag)
    {

        if($user === null){
            $user = new User();
        }

        $profilForm = $this->createForm(ProfilType::class, $user);

        $profilForm->handleRequest($request);

        if($profilForm->isSubmitted() && $profilForm->isValid()){
            /**
             * @var UploadedFile $photoFile
             */

            $photoFile = $profilForm->get('photoFile')->getData();
            $filename = md5(uniqid()). '.' . $photoFile->guessExtension();
            $photoFile->move('photo_user', $filename);

            $user->setUser($this->getUser());

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('user', ['id' => $this ->getUser() ->getId()] );
        }

        return $this->render('profil/profil.html.twig', [
            'profilForm' => $profilForm->createView(),
            'user' => $user,
            'tag' => $tag,
        ]);

    }
}
