<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\ProfileModificationType;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class ProfileModificationController extends Controller
{
    /**
     * @Route("/user/update/{id}", name="user_update", requirements={"id":"\d+"})
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param int $id
     * @param ObjectManager $manager
     * @return RedirectResponse|Response
     */
    public function update(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, AuthenticationUtils $utils)
    {

        $user = $this->getUser();
        dump($user);
        $form = $this->createForm(ProfileModificationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() & $form->isValid()) {
            //if inputs=null we get the last value
            if ($user->getPrenom() !== null) {
                $prenom = $user->getPrenom();
                $user->setPrenom($prenom);
            }
            if ($user->getNom() !== null) {
                $nom = $user->getNom();
                $user->setNom($nom);
            }
            if ($user->getTelephone() !== null) {
                $telephone = $user->getTelephone();
                    $user->setTelephone($telephone);

            }
            if ($user->getEmail() !== null) {
                $email = $user->getEmail();
                $user->setEmail($email);
            }
            if ($user->getSite() !== null) {
                $site = $user->getSite();
                $user->setSite($site);
            }
            try {
                $url = $form->get('fileTemp')->getData();
                $error = false;
                if ($url === null){
                    $user->getUrlPhoto();
                }else
                if ($user->getUrlPhoto() !== null) {
                    $extension = strtolower($url->getClientOriginalExtension());
                    $fileDownload = md5(uniqid(mt_rand(), true)) . '.' . $extension;
                    //$url->move($this->getParameter('path_dir').'photos/', $fileDownload);
                    $url->move($this->getParameter('download_dir'), $fileDownload);
                    if(strtolower($extension) != ‘jpg’ || strtolower($extension) != ‘png’ || strtolower($extension) != ‘jpeg’) {{
                        $this->addFlash('warning', 'format de l\'image non valide');
                    }
                    }else $user->setUrlPhoto($fileDownload);
                }
            } catch (\Exception $e) {
                dump($e->getMessage());

                //Ajout d'une erreur depuis le controller
                //$form->get('fileTemp')->addError(new FormError("Une erreur est survenue avec le fichier"));
                $this->addFlash('warning', 'fichier non valide');
                $error = true;
            }
            $passwordEncoder = $this->get('security.password_encoder');
            $passwordVerif = $form->get('password')->getData();

            if ($passwordEncoder->isPasswordValid($user, $passwordVerif) && !$error) {

                $manager->persist($user);
                $manager->flush();

                $this->addFlash('success', 'Votre profil est bien modifié!');
                return $this->redirectToRoute("user_update", ["id" => $user->getId()]);
            }else if (!$passwordEncoder->isPasswordValid($user, $passwordVerif)){
                $this->addFlash('warning', 'Modification impossible, mot de passe erroné!');
                return $this->redirectToRoute("user_update", ["id" => $user->getId()]);
            }
        }


        return $this->render('user/update.html.twig', [
            'userForm' => $form->createView(),
            'user' => $user
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
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route("/user/update/password/{id}", name="change_password", methods={"GET", "POST"})
     */
    public function changePassword(Request $request, int $id, ObjectManager $manager)
    {
        $em = $this->getDoctrine()->getManager();

        $repo = $manager->getRepository(User::class);
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $passwordEncoder = $this->get('security.password_encoder');
            $oldPassword = $request->request->get('change_password')['oldPassword'];

            if (!$passwordEncoder->isPasswordValid($user, $oldPassword)) {
                //$this->addFlash('warning', 'Mot de passe erroné !');
                $form->get('oldPassword')->addError(new FormError('Ancien mot de passe incorrect'));
            }

            if ($form->isValid()) {

                // Si l'ancien mot de passe est bon
                if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
                    $newEncodedPassword = $passwordEncoder->encodePassword($user, $form->get('password')->getData());
                    $user->setPassword($newEncodedPassword);
                    $id = $user->getId();
                    $em->persist($user);
                    $em->flush();

                    $this->addFlash('success', 'Votre mot de passe à bien été changé !');

                    return $this->redirectToRoute("user_update", ["id" => $user->getId()]);
                }
            }
        }

        return $this->render('user/password.html.twig', array(
            'passForm' => $form->createView(),
            'id' => $id,
            'user' => $user
        ));
    }

}
