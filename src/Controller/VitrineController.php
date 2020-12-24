<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VitrineController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(): Response
    {
        return $this->render('vitrine/index.html.twig', [
            'controller_name' => 'VitrineController',
        ]);
    }
    /**
     * @Route("/histoire", name="histoire")
     */
    public function Histoire(): Response
    {
        return $this->render('vitrine/histoire.html.twig', [
            'controller_name' => 'VitrineController',
        ]);
    }
    /**
     * @Route("/effectif", name="effectif")
     */
    public function Effectif(): Response
    {
        return $this->render('vitrine/effectif.html.twig', [
            'controller_name' => 'VitrineController',
        ]);
    }
    /**
     * @Route("/media", name="media")
     */
    public function Media(): Response
    {
        return $this->render('vitrine/media.html.twig', [
            'controller_name' => 'VitrineController',
        ]);
    }
    /**
     * @Route("/information", name="info")
     */
    public function Information(): Response
    {
        return $this->render('vitrine/info.html.twig', [
            'controller_name' => 'VitrineController',
        ]);
    }
}
