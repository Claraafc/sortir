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
    public function creerSortie(Request $request, ObjectManager $manager)
    {
        $sortie = new Sortie();

        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $repoVille = $this->getDoctrine()->getRepository(Ville::class);
        $villes = $repoVille->findAll();

        //recuperation user pour affichage du site
        $user = $this->getUser();

        //recuperation ID user pour remplir le champ Organisateur
        $sortie->setUser($this->getUser());
        $sortieForm->handleRequest($request);

       /* $organisateur = $this->getUser();
        $sortie->setUser($organisateur);*/

        if($sortieForm->isSubmitted() && $sortieForm->isValid()) {
           /* $site = $organisateur->getSite();
            $sortie->setSite($site);*/

            //etat par defaut 'ouverte'
           /* $etat = $this->getDoctrine()->getManager()->getRepository(Etat::class)->find(2);
            $sortie->setEtat($etat);*/
           $manager = $this->getDoctrine()->getManager();
           $sortie->setEtat('En creation');
           $sortie->setSite($this->getUser()->getSite());
                 $manager->persist($sortie);
            $manager->flush();

           $this->addFlash("success", "Sortie créée");
           return $this->redirectToRoute('sortie_creation');
        }


        return $this->render('sortie_creation/sortiecreation.html.twig', [
            'sortieForm' => $sortieForm->createView(),
            'villes' => $villes,
            'user' => $user,
        ]);
    }
}
