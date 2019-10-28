<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DetailSortieController extends Controller
{
    /**
     * @Route("/sortir/details/{id}", name="detail_sortie", requirements={"id": "\d+"})
     */
    public function detail(int $id, EntityManagerInterface $em)
{
    $repo = $em->getRepository(Sortie::class);
    $sortie = $repo->find($id);
    $users = $sortie->getUsers();
    //Si on ne trouve pas l'id ou quelle n'est plus publiée
    if(is_null($sortie)){
        throw $this->createNotFoundException("Sortie inconnue !!");
    }

    return $this->render("affichage_sortie/detail.html.twig", ["sortie" => $sortie, "users" => $users]);
}}