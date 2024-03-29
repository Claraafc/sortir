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
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AffichageSortieController extends Controller
{
    /**
     * @Route("/sortir/affichage", name="affichage_sortie")
     */
    public function afficherSortie(Request $request, ObjectManager $manager)
    {

        // Getting the locations
        $repoSite = $this->getDoctrine()->getRepository(Site::class);
        $sites = $repoSite->findAll();

        //we get the user's id for the requests
        $user = $this->getUser();

        //we get the requests from the repository by the HTML tag name
        $organisateur = $request->request->getBoolean('sortie_organisateur');
        $passee = $request->request->getBoolean('sortie_passee');
        $inscrit = $request->request->getBoolean('sortie_inscrit');
        $nonInscrit = $request->request->getBoolean('non_inscrit');
        $nomSortie = $request->request->get('nomSortie');
        $dateDebutRecherche = $request->get('dateDebutRecherche');
        $dateFinRecherche = $request->get('dateFinRecherche');
        $site = $request->request->get('site');



        $repoSite = $this->getDoctrine()->getRepository(Sortie::class);

        //we get the parameters for any field fulfilled or checkbox checked
        $sorties = $repoSite->findByParams($user, $inscrit, $nonInscrit, $nomSortie,$organisateur,$passee,$dateDebutRecherche,$dateFinRecherche, $site);

        return $this->render('affichage_sortie/accueil.html.twig', [
            "sorties"=> $sorties,
            "sites" => $sites,
            "siteSelection" => $site,
            "nomSortie" => $nomSortie,
            "sortie_organisateur" => $organisateur,
            "sortie_passee" => $passee,
            "sortie_inscrit" => $inscrit,
            "non_inscrit" => $nonInscrit,
            "dateDebutRecherche" => $dateDebutRecherche,
            "dateFinRecherche" => $dateFinRecherche
        ]);
    }
}
