<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\User;
use App\Entity\Ville;
use App\Form\SortieType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreationSortieController extends Controller
{
    /**
     * @Route("/sortir/creation", name="sortie_creation")
     */
    public function creerSortie(Request $request, ObjectManager $manager)
    {
        $sortie = new Sortie();
        // $siteID = new User();
        //$userID->getId();
        //$repoSite = $manager->getRepository(Site::class);

//Getting the user to be able to display his informations
        $user = $this->getUser();

        //Creation of a form
        $sortieForm = $this->createForm(SortieType::class, $sortie);

        // Getting the cities
        $repoVille = $this->getDoctrine()->getRepository(Ville::class);
        $villes = $repoVille->findAll();

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
            $etat = $this->getDoctrine()->getManager()->getRepository(Etat::class)->find(7);
            $sortie->setEtat($etat);


            $sortie->setSite($this->getUser()->getSite());
            $sortie->setOrganisateur($organisateur);
            var_dump($sortie);

            $manager->persist($sortie);
            $manager->flush();

            $this->addFlash("success", "Sortie créée");
            return $this->redirectToRoute('sortie_creation');
        }

        if ($sortieForm->isSubmitted() && $sortieForm->isValid() && $request->request->get('publier')) {
            //etat par defaut 'ouverte'
            $etat = $this->getDoctrine()->getManager()->getRepository(Etat::class)->find(8);
            $sortie->setEtat($etat);


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
            'villes' => $villes,
            'user' => $user,
            //'lieux' => $lieux,
            "site" => $site
        ]);
    }
}
