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
        $user = $this->getUser();

        $organisateur = $request->request->getBoolean('sortie_organisateur');
        $passee = $request->request->getBoolean('sortie_passee');
        $inscrit = $request->request->getBoolean('sortie_inscrit');
        $nonInscrit = $request->request->getBoolean('non_inscrit');
        $nomSortie = $request->request->get('nomSortie');
        $dateDebutRecherche = $request->get('dateDebutRecherche');
        $dateFinRecherche = $request->get('dateFinRecherche');
        $site = $request->request->get('site');

        $repoSite = $this->getDoctrine()->getRepository(Sortie::class);
        $sorties = $repoSite->findByParams($user, $inscrit, $nonInscrit, $nomSortie,$organisateur,$passee,$dateDebutRecherche,$dateFinRecherche, $site);

        return $this->render('affichage_sortie/accueil.html.twig', [
            "sorties"=> $sorties,
            "sites" => $sites
        ]);
    }
}
