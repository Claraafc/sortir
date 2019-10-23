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

class AffichageSortieController extends Controller
{
    /**
     * @Route("/sortir/affichage", name="affichage_sortie")
     */
    public function afficherSortie(Request $request, ObjectManager $manager)
    {
      //  $sortie = new Sortie();
        // $siteID = new User();
        //$userID->getId();
        //$repoSite = $manager->getRepository(Site::class);

        // Getting the locations
       $repoSite = $this->getDoctrine()->getRepository(Site::class);
        $sites = $repoSite->findAll();

        $repoSite = $this->getDoctrine()->getRepository(Sortie::class);
        $sorties = $repoSite->findAll();

        $users = $repoSite->findByInscrits($sorties);


        return $this->render('affichage_sortie/accueil.html.twig', [
            "sorties"=> $sorties,
            "sites" => $sites,
            'users' => $users
        ]);
    }
}
