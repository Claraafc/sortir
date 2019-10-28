<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @Route("/profile/{id}", name="profile_detail", requirements={"id": "\d+"})
     */
    public function index(int $id, EntityManagerInterface $em)
    {

        $repo = $em->getRepository(User::class);
        $user = $repo->find($id);


        if (is_null($user)){
            throw $this->createNotFoundException("Cet utilisateur n'existe pas!!");
        }
        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }
}
