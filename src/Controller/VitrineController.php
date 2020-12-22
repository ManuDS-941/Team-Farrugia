<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VitrineController extends AbstractController
{
    /**
     * @Route("/", name="vitrine")
     */
    public function index(): Response
    {
        return $this->render('vitrine/index.html.twig', [
            'controller_name' => 'VitrineController',
        ]);
    }
}
