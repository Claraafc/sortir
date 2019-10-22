<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class TestBaseHtmlController extends Controller
{
    /**
     * @Route("/", name="test_base_html")
     */
    public function index()
    {
        return $this->render('test_base_html/index.html.twig', [
            'controller_name' => 'TestBaseHtmlController',
        ]);
    }
}
