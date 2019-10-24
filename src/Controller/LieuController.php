<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Ville;
use App\Form\LieuType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LieuController extends Controller
{
    /**
     * @Route("/lieu", name="lieu")
     */
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
        return $this->render('lieu/index.html.twig', [
            'lieuForm' => $lieuForm->createView(),
        ]);
    }
}
