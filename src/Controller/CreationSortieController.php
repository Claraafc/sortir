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
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreationSortieController extends Controller
{
    public const ETAT_CREE = 25;
    public const ETAT_OUVERTE = 26;
    public const ETAT_CLOTUREE = 27;
    public const ETAT_EN_COURS = 28;
    public const ETAT_PASSEE = 29;
    public const ETAT_ANNULEE = 30;


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

        // Getting the cities
        /* $repoVille = $this->getDoctrine()->getRepository(Ville::class);
         $villes = $repoVille->findAll();*/

        // Getting the locations
        /* $repoLieux = $this->getDoctrine()->getRepository(Lieu::class);
         $lieux = $repoLieux->findAll();*/

        //Getting the school
        $repoSite = $this->getDoctrine()->getRepository(Site::class);
        $site = $repoSite->find($user->getSite());

        $organisateur = $this->getUser();

        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid() && $request->request->get('enregistrer')) {
            //setting state 'créée'
            $etat = $this->getDoctrine()->getManager()->getRepository(Etat::class)->find(self::ETAT_CREE);
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
        }

        if ($sortieForm->isSubmitted() && $sortieForm->isValid() && $request->request->get('publier')) {
            //etat par defaut 'ouverte'
            $etat = $this->getDoctrine()->getManager()->getRepository(Etat::class)->find(self::ETAT_OUVERTE);

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
            return $this->redirectToRoute('sortie_creation');
        }


        return $this->render('sortie_creation/sortiecreation.html.twig', [
            'sortieForm' => $sortieForm->createView(),
            'user' => $user,
            'site' => $site,
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

        // Getting the locations
        $sortieLieuId = $sortie->getLieu()->getId();
        $detailLieu = $manager->getRepository(Lieu::class)->find($sortieLieuId);

        //Verify that the user is the organizer of the event or is the administrator of the page
        if ($sortie->getOrganisateur() == $this->getUser() || $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $sortieForm = $this->createForm(SortieType::class, $sortie);
            $user = $this->getUser();

            // Getting the school
            $repoSite = $this->getDoctrine()->getRepository(Site::class);
            $site = $repoSite->find($user->getSite());

            $sortieForm->handleRequest($request);

            //save Sortie - not publishing
            if ($sortieForm->isSubmitted() && $sortieForm->isValid() && $request->request->get('enregistrer')) {

                //Lieu field is disabled so it retrieves NULL by default. To avoid the error we make a set...
                $lieu = $manager->getRepository(Lieu::class)->find($sortieLieuId);
                $sortie->setLieu($lieu);

                //setting état
                $etat = $this->getDoctrine()->getManager()->getRepository(Etat::class)->find(self::ETAT_CREE);
                $sortie->setEtat($etat);

                $manager->persist($sortie);
                $manager->flush();

                $this->addFlash('success', "Les modifications ont été sauvegardées");
                return $this->redirectToRoute('affichage_sortie');
            }

            //save Sortie and publish
            if ($sortieForm->isSubmitted() && $sortieForm->isValid() && $request->request->get('publier')) {
                //Lieu field is disabled so it retrieves NULL by default. To avoid the error we make a set...
                $lieu = $manager->getRepository(Lieu::class)->find($sortieLieuId);
                $sortie->setLieu($lieu);

                //setting état 'ouverte'
                $etat = $this->getDoctrine()->getManager()->getRepository(Etat::class)->find(self::ETAT_OUVERTE);
                $sortie->setEtat($etat);

                $manager->persist($sortie);
                $manager->flush();

                $this->addFlash('success', "La sortie a bien été publiée");
                return $this->redirectToRoute('affichage_sortie');
            }

            //delete Sortie if state = crée
            if ($sortieForm->isSubmitted() && $request->request->get('supprimer') && $sortie->getEtat()->getId() == self::ETAT_CREE) {
                $manager->remove($sortie);
                $manager->flush();

                $this->addFlash('success', "La sortie a bien été supprimée");
                return $this->redirectToRoute('affichage_sortie');
            }

            //cancel Sortie if state != crée
            if ($sortieForm->isSubmitted() && $request->request->get('supprimer') && $sortie->getEtat()->getId() != self::ETAT_CREE) {

                return $this->redirectToRoute('annuler_sortie', ["id" => $sortieId]);
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
        ]);
    }

    /**
     * @Route("/sortir/annuler/{id}", name="annuler_sortie", requirements={"id": "\d+"})
     */
    public function annulerSortie(Sortie $sortie, Request $request, ObjectManager $manager)
    {
        //variable to hide form fields : rue, latitude, longitude, code postal, ville(<option>)
        $hidden = true;

        if ($sortie->getOrganisateur() == $this->getUser() || $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $sortieForm = $this->createForm(SupprimerSortieType::class, $sortie);
            $sortieForm->handleRequest($request);

            if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
                //Setting state "annulee"
                $etat = $this->getDoctrine()->getManager()->getRepository(Etat::class)->find(self::ETAT_ANNULEE);
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

    /*
     * @Route("/sortir/inscription/{id}", name="inscriptiondos_sortie", requirements={"id": "\d+"})
     *
    public function inscription(int $id, ObjectManager $manager)
    {
        $date = new \DateTime('now');

        $SortieRepository = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie = $SortieRepository->find($id);
        // on inscrit l'utilisateur si il reste de places
        if (count($sortie->getUsers()) < $sortie->getNbInscriptionsMax()) {
            // on inscrit l'utilisateur si la date de clôture est ouverte
            if ($sortie->getDateCloture() > $date) {

                $sortie->addUser($this->getUser());
                $manager->persist($sortie);
                $manager->flush();

            } else {
                $this->addFlash('danger', "Désolé, nous n'acceptons plus d'inscriptions");
            }

        } else {
            $this->addFlash('danger', "Il n'y est plus de place pour cette sortie !");
        }
        return $this->redirectToRoute('affichage_sortie');
    }


    /*
     * @Route("/sortir/desister/{id}", name="desister_sortir", requirements={"id": "\d+"})
     *
    public function desister(int $id, ObjectManager $manager)
    {
        $sortieRepository = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie = $sortieRepository->find($id);

        // supprime l'utilisateur de la liste des participants
        $sortie->removeUser($this->getUser());
        $manager->persist($sortie);
        $manager->flush();
        return $this->redirectToRoute('affichage_sortie');
    }*/

}
