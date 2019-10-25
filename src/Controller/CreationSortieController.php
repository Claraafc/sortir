<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Form\SortieType;
use App\Repository\LieuRepository;
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
            //etat par defaut 'créée'
            $etat = $this->getDoctrine()->getManager()->getRepository(Etat::class)->find(61);
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

        if ($sortieForm->isSubmitted() && $sortieForm->isValid() && $request->request->get('publier')) {
            //etat par defaut 'ouverte'
            $etat = $this->getDoctrine()->getManager()->getRepository(Etat::class)->find(62);

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
            var_dump($sortie);

            $manager->persist($sortie);
            $manager->flush();

            $this->addFlash("success", "Sortie créée");
            return $this->redirectToRoute('sortie_creation');
        }


        return $this->render('sortie_creation/sortiecreation.html.twig', [
            'sortieForm' => $sortieForm->createView(),
            'user' => $user,
            "site" => $site,
        ]);
    }

    /**
     * @Route("/sortir/creation/ajax/{id}", name="sortie_ajax")
     */
    public function requeteAjax(Ville $ville, LieuRepository $lieuRepository){
        $lieux = $lieuRepository->findBy([
           'ville' => $ville

        ]);
        return new JsonResponse($lieux);
    }

    /**
     * @Route("/sortir/creation/requeteLieu/{id}", name="sortie_requeteLieu")
     */
    public function requeteLieu(Lieu $lieu, ObjectManager $manager){
        $detailLieu = $manager->getRepository(Lieu::class)->find($lieu);
        $tabLieu= [
            'rue'=> $detailLieu->getRue(),
            'latitude'=> $detailLieu->getLatitude(),
            'longitude'=> $detailLieu->getLongitude(),
            'codePostal'=> $detailLieu->getVille()->getCodePostal(),
        ];
        return new JsonResponse($tabLieu);
    }
}
