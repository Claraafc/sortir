<?php

namespace App\Controller;

use App\Entity\Site;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends Controller
{
    /**
     * @Route("/site", name="site")
     */
    public function list(EntityManagerInterface $em)
    {
        $sites = $em->getRepository(Site::class)->findAll();

        return $this->render('affichage_sortie/accueil.html.twig', [
            'sites' => $sites
        ]);
    }
}
