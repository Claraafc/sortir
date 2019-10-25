<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\User;
use App\Entity\Ville;
use App\Form\SortieType;
use App\Repository\LieuRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
            $etat = $this->getDoctrine()->getManager()->getRepository(Etat::class)->find(31);
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
            $etat = $this->getDoctrine()->getManager()->getRepository(Etat::class)->find(32);
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
     * @Route("/sortir/creation/ajax/{id}", name="sortie_requeteAjax")
     */
    public function requeteAjax(Ville $ville, LieuRepository $lieuRepository){

        $lieux = $lieuRepository->findBy([
           'ville' => $ville
        ]);
        return new JsonResponse($lieux);
      /*  $select = $request->request->get('choix');
        $lieux = $manager->getRepository(Lieu::class)->findBy(['ville'=>$select]);
        $lieuTab = [];
        foreach ($lieux as $lieu){
            $lieuTab[$lieu->getId()] = $lieu->getNom();
        }
        $response = new Response(json_encode($lieuTab));
        $response->headers->set('Content-Type', 'application/json');
        return $response;*/
    }
    /**
     * @Route("/sortir/creation/requeteLieu", name="sortie_requeteLieu")
     */
    public function requeteLieu(Request $request, ObjectManager $manager){
        $infoLieu = $request->request->get('detailLieu');
        $detail = $manager->getRepository(Lieu::class)->find($infoLieu);
        $lieu = [
            'rue' => $detail->getRue(),
            'latitude' => $detail->getLatitude(),
            'longitude' => $detail->getLongitude(),
            'cp'=> $detail->getVille()->getCodePostal(),
        ];
        $response = new Response(json_encode($lieu));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
