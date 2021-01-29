<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\SiteRepository;
use App\Repository\TarifRepository;
use App\Repository\AccueilRepository;
use App\Repository\HoraireRepository;
use App\Repository\ChampionRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Notification\ContactNotification;
use App\Notification\MessageNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class VitrineController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(AccueilRepository $repo, AuthorizationCheckerInterface $authChecker): Response
    {
        // Si on est pas connecter on peut acceder au site a enlever quand fini
        if(!$authChecker->isGranted('ROLE_ADMIN'))
        {
            return $this->redirectToRoute('connexion');
        }

        $accueil = $repo->findAll();

        return $this->render('vitrine/index.html.twig', [
            'accueil' => $accueil
        ]);
    }
    /**
     * @Route("/histoire", name="histoire")
     */
    public function Histoire(AuthorizationCheckerInterface $authChecker): Response
    {
        // Si on est pas connecter on peut acceder au site a enlever quand fini
        if(!$authChecker->isGranted('ROLE_ADMIN'))
        {
            return $this->redirectToRoute('connexion');
        }

        return $this->render('vitrine/histoire.html.twig', [
            'controller_name' => 'VitrineController',
        ]);
    }
    
    /**
     * @Route("/medias", name="medias")
     */
    public function Medias(ChampionRepository $repo, AuthorizationCheckerInterface $authChecker): Response
    {
        // Si on est pas connecter on peut acceder au site a enlever quand fini
        if(!$authChecker->isGranted('ROLE_ADMIN'))
        {
            return $this->redirectToRoute('connexion');
        }

        $champion = $repo->findAll();

        return $this->render('vitrine/medias.html.twig', [
            'champion' => $champion
        ]);
    }

    /**
     * @Route("/information", name="info")
     */
    public function Information(HoraireRepository $repo, TarifRepository $repo1, SiteRepository $repo2, AuthorizationCheckerInterface $authChecker): Response
    {
        // Si on est pas connecter on peut acceder au site a enlever quand fini
        if(!$authChecker->isGranted('ROLE_ADMIN'))
        {
            return $this->redirectToRoute('connexion');
        }

        $horaire = $repo->findAll();
        $tarif = $repo1->findAll();
        $site = $repo2->findAll();

        return $this->render('vitrine/info.html.twig', [
            'horaire' => $horaire,
            'tarif' => $tarif,
            'site' => $site
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function Contact(Request $request, EntityManagerInterface $manager, MessageNotification $notification, AuthorizationCheckerInterface $authChecker): Response
    {
        // Si on est pas connecter on peut acceder au site a enlever quand fini
        if(!$authChecker->isGranted('ROLE_ADMIN'))
        {
            return $this->redirectToRoute('connexion');
        }

        $message = new Message();
        

        // dump($request);
        
        $formContact = $this->createForm(MessageType::class, $message);

        $formContact->handleRequest($request);

        // dump($request);

        if($formContact->isSubmitted() && $formContact->isValid()) 
        {
            $notification->notify($message);
            $this->addFlash('success', 'Votre E-Mail a bien été envoyé');

            $manager->persist($message); // On maintient l'insertion en BDD dans la variable $message
            $manager->flush(); // On execute l'insertion

            // $message = "Le message a bien été ajouté !!";

            // $this->addFlash('success', "Le message a bien été transmis !!");

            return $this->redirectToRoute('accueil');
        }

        return $this->render('vitrine/contact.html.twig', [
            'formContact' => $formContact->createView()
        ]);
    }
    /**
     * @Route("/mention", name="mention")
     */
    public function Mention(): Response
    {
        return $this->render('vitrine/mention.html.twig');
    }

    /**
     * @Route("/politique", name="politique")
     */
    public function Politique(): Response
    {
        return $this->render('vitrine/politique.html.twig');
    }
}
