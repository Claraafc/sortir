<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\ProfileModificationType;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class ProfileModificationController extends Controller
{
    /**
     * @Route("/user/update/{id}", name="user_update", requirements={"id":"\d+"})
     *
     */
    public function update(User $user, Request $request, EntityManagerInterface $em, int $id, ObjectManager $manager)
    {

        $form = $this->createForm(ProfileModificationType::class,$user);
        $form2 = $this->createForm(ChangePasswordType::class);

        $form->handleRequest($request);
        $form2->handleRequest($request);
        $repo = $manager->getRepository(User::class);
        $user = $repo->find($id);
        $mdp = $user->getPassword();

        if($form->isSubmitted() && $form->isValid() && $form2->isSubmitted() && $form2->isValid()){
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre profil est bien modifié!');
            return $this->redirectToRoute('affichage_sortie');
        }


        return $this->render('user/update.html.twig', [
            'userForm' => $form->createView(),
            'passForm' =>$form2->createView(),
            'user' => $user,
            'id' => $id,
            'mdp' => $mdp
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


}
