<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use function Sodium\add;

class InscriptionSortieController extends Controller
{
    /**
     * @Route("/inscription/sortie/{id}", name="inscription_sortie")
     */
    public function inscription(ObjectManager $manager, Sortie $sortie)
    {
        //Setting the parameters used for te conditions

        //Getting the actual user
        $user = $this->getUser();
        //Getting the participants
        $users = $sortie->getUsers();
        $dateDuJour = new \DateTime('now');
        $nbMaxParticipants = $sortie->getNbInscriptionsMax();


        //Checking if the number of participants is not over the limit of the event
        if (count($sortie->getUsers()) < $nbMaxParticipants && $sortie->getEtat() === 20) {
            $sortie->addUser($user);
            //var_dump($sortie);

            $manager->persist($sortie);
            $manager->flush();
        } else if (!count($sortie->getUsers()) < $nbMaxParticipants) {
            $this->addFlash('danger', 'Le nombre maximum de participants est déjà atteint');
        } else if (!$sortie->getEtat() === 20) {
            $this->addFlash('danger', 'La sortie n\'est pas ouverte à l\'inscription');
        } else if ($sortie->getDateCloture() < $dateDuJour){
            $this->addFlash('danger', 'Il n\'est plus possible de s\'inscrire à cette sortie');
        }

            return $this->redirectToRoute('affichage_sortie');
        /* return $this->render('affichage_sortie/accueil.html.twig', [
             'user' => $user,
             'users'=> $users,
             'sortie' => $sortie
         ]);*/
    }
}
