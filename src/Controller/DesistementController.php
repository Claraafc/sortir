<?php

namespace App\Controller;

use App\Entity\Sortie;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DesistementController extends Controller
{
    /**
     * @Route("/desistement/{id}", name="desistement")
     */
    public function index(ObjectManager $manager, Sortie $sortie)
    {

        $user = $this->getUser();
        $dateDuJour = new \DateTime('now');

        if (isset($user)) {

            /* Checking if the event is not passed closed or deleted before removing a user from it*/
            if ($sortie->getEtat()->getLibelle() === 'ouverte' || $sortie->getEtat()->getLibelle() === 'cloturee') {
                $sortie->removeUser($user);

                $manager->persist($sortie);
                $manager->flush();
                $this->addFlash('success','Votre désistement a bien été pris en compte');
            }else{
                $this->addFlash('danger', 'impossible de s\'inscrire à cette sortie');
            }
            return $this->redirectToRoute('affichage_sortie');

        }
    }
}

