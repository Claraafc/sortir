<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Form\SortieType;
use App\Form\SupprimerSortieType;
use App\Repository\LieuRepository;
use App\Repository\VillesRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreationSortieController extends Controller
{

    /**
     * @Route("/sortir/creation", name="sortie_creation", methods={"POST", "GET"})
     */
    public function creerSortie(Request $request, ObjectManager $manager)
    {
        $sortie = new Sortie();

        //Getting the user to be able to display his informations
        $user = $this->getUser();

        //Creation of a form
        $sortieForm = $this->createForm(SortieType::class, $sortie);

        //Getting the school
        $repoSite = $this->getDoctrine()->getRepository(Site::class);
        $site = $repoSite->find($user->getSite());

        $organisateur = $this->getUser();


        $sortieForm->handleRequest($request);

        $lieu = $sortie->getLieu();

        if ($request->request->get('enregistrer')) {
            if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {

                $etat = $this->getDoctrine()->getManager()->getRepository(Etat::class)->findOneBySomeField('cree');

                $sortie->setEtat($etat);

                //file
                $file = $sortieForm->get('urlPhoto')->getData();
                if (!is_null($file)) {
                    // File name
                    $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                    // Move the file to the directory
                    try {
                        $file->move('../public/asset/images/', $fileName);
                    } catch (FileException $e) {
                    }
                    $sortie->setUrlPhoto($fileName);
                }
                //end file

                $sortie->setSite($this->getUser()->getSite());
                $sortie->setOrganisateur($organisateur);

                $manager->persist($sortie);
                $manager->flush();

                $this->addFlash("success", "Sortie créée");
                return $this->redirectToRoute('affichage_sortie');
            } else {
                $this->addFlash('danger', 'Erreur lors de l\'enregistrement de la sortie');
            }
        }
        if ($request->request->get('publier')) {
            if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
                //etat par defaut 'ouverte'
                $etat = $this->getDoctrine()->getManager()->getRepository(Etat::class)->findOneBySomeField('ouverte');

                $sortie->setEtat($etat);


                //file
                $file = $sortieForm->get('urlPhoto')->getData();
                if (!is_null($file)) {
                    // Création du nom du fichier
                    $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                    // Move the file to the directory
                    try {
                        $file->move('../public/asset/images/', $fileName);
                    } catch (FileException $e) {
                    }
                    $sortie->setUrlPhoto($fileName);
                }
                //end file

                $sortie->setSite($this->getUser()->getSite());
                $sortie->setOrganisateur($organisateur);

                $manager->persist($sortie);
                $manager->flush();

                $this->addFlash("success", "Sortie créée");
                return $this->redirectToRoute('affichage_sortie');
            } else {
                $this->addFlash('danger', 'Erreur lors de la publication de la sortie');
            }
        }


        return $this->render('sortie_creation/sortiecreation.html.twig', [
            'sortieForm' => $sortieForm->createView(),
            'user' => $user,
            'site' => $site,
            'lieu' => $lieu
        ]);
    }


    //Javascript - Filter the places according to the chosen city

    /**
     * @Route("/sortir/creation/ajax/{id}", name="sortie_ajax")
     */
    public function requeteAjax(Ville $ville, LieuRepository $lieuRepository)
    {
        $lieux = $lieuRepository->findBy([
            'ville' => $ville

        ]);
        return new JsonResponse($lieux);
    }

    //Javascript - Show the details of the chosen place

    /**
     * @Route("/sortir/creation/requeteLieu/{id}", name="sortie_requeteLieu")
     */
    public function requeteLieu(Lieu $lieu, ObjectManager $manager)
    {
        $detailLieu = $manager->getRepository(Lieu::class)->find($lieu);
        $tabLieu = [
            'rue' => $detailLieu->getRue(),
            'latitude' => $detailLieu->getLatitude(),
            'longitude' => $detailLieu->getLongitude(),
            'codePostal' => $detailLieu->getVille()->getCodePostal(),
        ];
        return new JsonResponse($tabLieu);
    }

    /**
     * @Route("/sortir/update/{id}", name="sortie_update", requirements={"id": "\d+"})
     */
    public function updateSortie(Sortie $sortie, Request $request, ObjectManager $manager)
    {
        //variable to hide form fields : rue, latitude, longitude, code postal, ville(<option>)
        $hidden = true;

        $sortieId = $sortie->getId();
        $sortiePhoto = $sortie->getUrlPhoto();

      // dump($request->request);

        // Getting the locations
        $sortieLieuId = $sortie->getLieu()->getId();
        $detailLieu = $manager->getRepository(Lieu::class)->find($sortieLieuId);

        //Verify that the user is the organizer of the event or is the administrator of the page
        if (($sortie->getOrganisateur() == $this->getUser() || $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) && $sortie->getEtat()->getLibelle() == 'cree') {
            $sortieForm = $this->createForm(SortieType::class, $sortie);
            $user = $this->getUser();

            // Getting the school
            $repoSite = $this->getDoctrine()->getRepository(Site::class);
            $site = $repoSite->find($user->getSite());

            $sortieForm->handleRequest($request);

            //save Sortie - not publishing
            if ($request->request->get('enregistrer')) {
                if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {

                    $file = $sortieForm->get('urlPhoto')->getData();
                    if (!is_null($file)) {
                        // Création du nom du fichier
                        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                        // Move the file to the directory

                        $file->move('../public/asset/images/', $fileName);

                        $sortie->setUrlPhoto($fileName);
                    } else {
                        $sortie->setUrlPhoto($sortiePhoto);
                    }

                    //Lieu field is disabled so it retrieves NULL by default. To avoid the error we make a set...
                    $lieu = $manager->getRepository(Lieu::class)->find($sortieLieuId);
                    $sortie->setLieu($lieu);

                    //setting état
                    $etat = $this->getDoctrine()->getManager()->getRepository(Etat::class)->findOneBySomeField('cree');
                    $sortie->setEtat($etat);

                    $manager->persist($sortie);
                    $manager->flush();

                    $this->addFlash('success', "Les modifications ont été sauvegardées");
                    return $this->redirectToRoute('affichage_sortie');
                } else {
                    $this->addFlash('danger', 'Erreur lors de la modification de la sortie');
                }
            }

            //save Sortie and publish
            if ($request->request->get('publier')) {
                if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {


                   $file = $sortieForm->get('urlPhoto')->getData();
                    if (!is_null($file)) {
                        // Création du nom du fichier
                        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                        // Move the file to the directory

                            $file->move('../public/asset/images/', $fileName);

                        $sortie->setUrlPhoto($fileName);
                    } else {
                        $sortie->setUrlPhoto($sortiePhoto);
                    }
                    //Lieu field is disabled so it retrieves NULL by default. To avoid the error we make a set...
                    $lieu = $manager->getRepository(Lieu::class)->find($sortieLieuId);
                    $sortie->setLieu($lieu);

                    //setting état 'ouverte'
                    $etat = $this->getDoctrine()->getManager()->getRepository(Etat::class)->findOneBySomeField('ouverte');
                    $sortie->setEtat($etat);

                    $manager->persist($sortie);
                    $manager->flush();

                    $this->addFlash('success', "La sortie a bien été publiée");
                    return $this->redirectToRoute('affichage_sortie');
                } else {
                    $this->addFlash('danger', 'Erreur lors de la publication de la sortie');
                }
            }

            //delete Sortie if state = crée
            if ($request->request->get('supprimer')) {
                if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
                    $manager->remove($sortie);
                    $manager->flush();

                    $this->addFlash('success', "La sortie a bien été supprimée");
                    return $this->redirectToRoute('affichage_sortie');
               /* } else if ($sortieForm->isSubmitted() && $request->request->get('supprimer') && $sortie->getEtat()->getLibelle() != 'cree') {
                    return $this->redirectToRoute('annuler_sortie', ["id" => $sortieId]);*/
                } else {
                    $this->addFlash('danger', 'Erreur lors de la suppression de la sortie');
                }
            }

        } else {
            $this->addFlash('danger', "Vous ne pouvez pas modifier cette sortie");
            return $this->redirectToRoute('affichage_sortie');
        }

        return $this->render('sortie_creation/sortieupdate.html.twig', [
            'sortieForm' => $sortieForm->createView(),
            'user' => $user,
            'site' => $site,
            'sortie' => $sortieId,
            'hidden' => $hidden,
            'detailsSortie' => $sortie
        ]);
    }

    /**
     * @Route("/sortir/annuler/{id}", name="annuler_sortie", requirements={"id": "\d+"})
     */
    public
    function annulerSortie(Sortie $sortie, Request $request, ObjectManager $manager)
    {
        //variable to hide form fields : rue, latitude, longitude, code postal, ville(<option>)
        $hidden = true;

        if (($sortie->getOrganisateur() == $this->getUser() || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) && $sortie->getEtat()->getLibelle() == 'ouverte') {

            $sortie->setUrlPhoto(null);
            $sortieForm = $this->createForm(SupprimerSortieType::class, $sortie);
            $sortieForm->handleRequest($request);

            if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
                //Setting state "annulee"
                $etat = $this->getDoctrine()->getManager()->getRepository(Etat::class)->findOneBySomeField('annulee');
                $sortie->setEtat($etat);

                $manager->persist($sortie);
                $manager->flush();

                $this->addFlash('success', "La sortie a bien été annulée");
                return $this->redirectToRoute('affichage_sortie');
            }

        } else {
            $this->addFlash('danger', "Vous ne pouvez pas annuler cette sortie");
            return $this->redirectToRoute('affichage_sortie');
        }

        return $this->render('sortie_creation/sortieannuler.html.twig', [
            'sortieForm' => $sortieForm->createView(),
            'hidden' => $hidden
        ]);
    }

}
