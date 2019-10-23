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
        $userID = new User();
        //$userID->getId();
        $repoSite = $manager->getRepository(Site::class);


        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $repoVille = $this->getDoctrine()->getRepository(Ville::class);
        $villes = $repoVille->findAll();

        $site = $this->getDoctrine()->getRepository(Site::class);
        $site->findAll();
        //recuperation user pour affichage du site
        $user = $this->getUser();
        $userID->setSite();

        //recuperation ID user pour remplir le champ Organisateur
        $sortie->setOrganisateur($this->getUser());
        $sortieForm->handleRequest($request);

       $organisateur = $this->getUser();
        $sortie->setOrganisateur($organisateur);



        $site = $repoSite->find($idSite);


       /* if($sortieForm->isSubmitted() && $sortieForm->isValid()) {
            $site = $organisateur->getSite();
            $sortie->setSite($site);

            //etat par defaut 'ouverte'
           /* $etat = $this->getDoctrine()->getManager()->getRepository(Etat::class)->find(2);
            $sortie->setEtat($etat);
           $manager = $this->getDoctrine()->getManager();
           $sortie->setEtat('En creation');
           $sortie->setSite($this->getUser()->getSite());
                 $manager->persist($sortie);
            $manager->flush();

           $this->addFlash("success", "Sortie créée");
           return $this->redirectToRoute('sortie_creation');
        }*/


        return $this->render('sortie_creation/sortiecreation.html.twig', [
            'sortieForm' => $sortieForm->createView(),
            'villes' => $villes,
            'user' => $user,
            'site' => $site->getId()
        ]);
    }
}
