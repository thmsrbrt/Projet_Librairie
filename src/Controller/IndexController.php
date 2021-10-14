<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index_index")
     */
    public function index()
    {
        return $this->render('layout.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}
