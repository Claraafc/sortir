<?php

namespace App\Controller;

use App\Repository\SortiesRepository;
use Doctrine\Common\Persistence\ObjectManager;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class AffichageSortieController extends Controller
{
    /**
     * @Route("/", name="affichage_sortie")
     */
    public function home()
    {
        return $this->render('affichage_sortie/accueil.html.twig', [
            'controller_name' => 'AffichageSortieController',
        ]);
    }

    public function listName(SortiesRepository $sortiesRepository){
       //utilisation de la méthode getName() réalisé dans le SortiesRepository
        $nameSortie= $sortiesRepository->getName();

        return $this->render('affichage_sortie/accueil.html.twig',[
            'nameSorties' => $nameSortie,
        ]);

    }
}
