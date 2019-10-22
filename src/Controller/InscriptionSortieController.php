<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionSortieController extends Controller
{
    /**
     * @Route("/inscription/sortie", name="inscription_sortie")
     */
    public function inscription(ObjectManager $manager, User  $user)
    {



        return $this->render('inscription_sortie/index.html.twig', [
            'controller_name' => 'InscriptionSortieController',
        ]);
    }
}
