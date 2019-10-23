<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileModificationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class ProfileModificationController extends Controller
{
    /**
     * @Route("/user/update/{id}", name="user_update", requirements={"id":"\d+"})
     */
    public function update(User $user, Request $request, EntityManagerInterface $em)
    {

        $form = $this->createForm(ProfileModificationType::class,$user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre profil est bien modifie !');
            return $this->redirectToRoute('affichage_sortie');
        }


        return $this->render('user/update.html.twig', [
            'categoryForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/file/{id}", name="user_file")
     */
    public function fichier(User $user){

        //$dir = $this->getParameter('path_dir').'download/';
        $dir = $this->getParameter('download_dir');

        if(strlen(trim($user->getFile())) > 0 && file_exists($dir . $user->getFile())) {

            $filename = $user->getTitle();
            // this is needed to safely include the file name as part of the URL
            $safeFilename = \transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $filename);

            $f = explode('.', $user->getFile());
            $extension = strtolower($f[count($f) - 1]);

            $nameFile = $safeFilename.'.'.$extension;

            $file = new File($dir . $user->getFile());

            return $this->file($file, $nameFile);
        }
        else{
            throw $this->createNotFoundException("File not found");
        }
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('user/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){}
}
