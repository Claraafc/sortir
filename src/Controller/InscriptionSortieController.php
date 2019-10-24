<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionSortieController extends Controller
{
    /**
     * @Route("/inscription/sortie", name="inscription_sortie")
     */
    public function inscription(ObjectManager $manager, Sortie $sortie)
    {
            $tabUser = [];
            $user = $this->getUser();
            $tabUser[] = $user;
            $nbMaxParticipants = $sortie->getNbInscriptionsMax();

            /* Checking if the number of participants is not over the limit of the event*/
           if(count($tabUser) < $nbMaxParticipants )
            $sortie->setParticipants($tabUser);


            if(!$user == null){
                $manager->persist($sortie);
                $manager->flush();
            }




        return $this->render('inscription_sortie/index.html.twig', [
            'controller_name' => 'InscriptionSortieController',
        ]);
    }
}
