<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Form\LieuType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LieuController extends Controller
{
    /**
     * @Route("/lieu", name="lieu")
     */
    //new lieu
    public function index(Request $request)
    {
        $lieu = new Lieu();

        $lieuForm = $this->createForm(LieuType::class, $lieu);
        $lieuForm->handleRequest($request);

        if($lieuForm->isSubmitted() && $lieuForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lieu);
            $em->flush();
            return $this->redirectToRoute('sortie_creation');
        }
        return $this->render('lieu/lieucreation.html.twig', [
            'lieuForm' => $lieuForm->createView(),
        ]);
    }

    /**
     * @Route("/lieu/update/{id}", name="lieu_update", requirements={"id": "\d+"})
     */
    public function updateLieu(Sortie $sortie, Request $request, ObjectManager $manager) {

        //find all the details of the place
        $sortieLieuId = $sortie->getLieu()->getId();
        $detailLieu = $manager->getRepository(Lieu::class)->find($sortieLieuId);

        //find ville
        $villeId = $detailLieu->getVille();
        $ville = $manager->getRepository(Ville::class)->find($villeId);

        //get id to send in url (sortie_update)
        $sortieId = $sortie->getId();

        $lieuForm = $this->createForm(LieuType::class, $detailLieu);
        $lieuForm->handleRequest($request);

        if($lieuForm->isSubmitted() && $lieuForm->isValid()) {

            $manager->persist($detailLieu);
            $manager->flush();
            return $this->redirectToRoute('sortie_update', ["id" => $sortieId]);
        }
        return $this->render('lieu/lieuupdate.html.twig', [
            'lieuForm' => $lieuForm->createView(),
            'sortieID' => $sortieId
        ]);
    }
}
