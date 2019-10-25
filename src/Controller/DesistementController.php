<?php

namespace App\Controller;

use App\Entity\Sortie;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DesistementController extends Controller
{
    /**
     * @Route("/desistement", name="desistement")
     */
    public function index(ObjectManager $manager, Sortie $sortie)
    {


        $user = $this->getUser();

        if (!$user == null) {

            /* Checking if the event is not passed closed or deleted before removing a user from it*/
            if ($sortie->getEtat() === 8) {
                $sortie->removeUser($user);

                $manager->persist($sortie);
                $manager->flush();
            }
            return $this->render('desistement/index.html.twig', [
                'controller_name' => 'DesistementController'
            ]);

        }
    }
}

