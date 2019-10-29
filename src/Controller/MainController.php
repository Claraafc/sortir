<?php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{
    /**
     * @Route("/", name="main")
     */
    public function home(EntityManagerInterface $em)
    {
        /*$repo = $em->getRepository(User::class);
        $user = $this->getUser();
        $id = $user->getId();
        $em->persist($user);
        $em->flush();
        return $this->render('security/login.html.twig', [
            'user' => $user,
            'id' => $id
        ]);*/
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
            return $this->redirectToRoute('affichage_sortie');
        }
        return $this->redirectToRoute('app_login');
    }







}