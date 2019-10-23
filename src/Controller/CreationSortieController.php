<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Form\SortieType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreationSortieController extends Controller
{
    /**
     * @Route("/sortir/creation", name="sortie_creation")
     */
    public function creation(Request $request, ObjectManager $manager)
    {
        $sortie = new Sortie();

        $formSortie = $this->createForm(SortieType::class, $sortie);
        $formSortie->handleRequest($request);

       /* $organisateur = $this->getUser();
        $sortie->setUser($organisateur);*/

        if($formSortie->isSubmitted() && $formSortie->isValid()) {
           /* $site = $organisateur->getSite();
            $sortie->setSite($site);*/

            //etat par defaut 'ouverte'
           /* $etat = $this->getDoctrine()->getManager()->getRepository(Etat::class)->find(2);
            $sortie->setEtat($etat);*/

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($sortie);
            $manager->flush();

           $this->addFlash("success", "Sortie créée");
         //   return $this->redirectToRoute('affichage_sortie');
        }


        return $this->render('sortie_creation/sortiecreation.html.twig', [
            'formSortie' => $formSortie->createView()
        ]);
    }
}
