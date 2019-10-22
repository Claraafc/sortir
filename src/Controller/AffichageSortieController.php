<?php

namespace App\Controller;

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
}
