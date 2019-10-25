<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionSortieController extends Controller
{
    /**
     * @Route("/inscription/sortie/{id}", name="inscription_sortie")
     */
    public function inscription(ObjectManager $manager, Sortie $sortie)
    {
        $sortie->getId();
        //Getting the actual user
        $user = $this->getUser();
        //Getting the participants
        $users = $sortie->getUsers();
        $nbMaxParticipants = $sortie->getNbInscriptionsMax();

        if (!$user == null) {
            //Checking if the number of participants is not over the limit of the event
            if (count($sortie->getUsers()) < $nbMaxParticipants && $sortie->getEtat() === 14)
                $sortie->addUser($user);
                var_dump($sortie);

            $manager->persist($sortie);
            $manager->flush();
        }


        return $this->render('affichage_sortie/detail.html.twig', [
            'user' => $user,
            'users'=> $users,
            'sortie' => $sortie
        ]);
    }
}
