<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/medias", name="medias")
     */
    public function Medias(): Response
    {
        return $this->render('vitrine/medias.html.twig', [
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

    /**
     * @Route("/contact", name="contact")
     */
    public function Contact(Request $request, Message $message = null, EntityManagerInterface $manager): Response
    {
        
        $message = new Message;
        

        // dump($request);
        
        $formContact = $this->createForm(MessageType::class, $message);

        $formContact->handleRequest($request);

        dump($request);

        if($formContact->isSubmitted() && $formContact->isValid()) 
        {
            $manager->persist($message); // On maintient l'insertion en BDD dans la variable $message
            $manager->flush(); // On execute l'insertion

            $message = "Le message a bien été ajouté !!";

            $this->addFlash('success', "Le message a bien été transmis !!");

            return $this->redirectToRoute('contact');
        }

        return $this->render('vitrine/contact.html.twig', [
            'formContact' => $formContact->createView()
        ]);
    }
}
