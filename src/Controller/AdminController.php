<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
use App\Form\InscriptionType;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(Request $request): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'request' => $request
        ]);
    }
    /**
     * @Route("/admin/accueil", name="admin_accueil")
     */
    public function GestionAccueil(Request $request): Response
    {
        return $this->render('admin/gestion_accueil.html.twig', [
            'controller_name' => 'AdminController',
            'request' => $request
        ]);
    }
    /**
     * @Route("/admin/medias", name="admin_medias")
     */
    public function GestionMédias(Request $request): Response
    {
        return $this->render('admin/gestion_medias.html.twig', [
            'controller_name' => 'AdminController',
            'request' => $request
        ]);
    }
    /**
     * @Route("/admin/info", name="admin_info")
     */
    public function GestionInformations(Request $request): Response
    {
        return $this->render('admin/gestion_info.html.twig', [
            'controller_name' => 'AdminController',
            'request' => $request
        ]);
    }
    /**
     * @Route("/admin/message", name="admin_message")
     */
    public function GestionMessage(EntityManagerInterface $manager, MessageRepository $repo, Request $request): Response
    {
        $tableau = $manager->getClassMetadata(Message::class)->getFieldNames(); // Selectionne les métas données

        $message = $repo->findAll();

        dump($request);

        return $this->render('admin/gestion_message.html.twig', [
            'tableau' => $tableau,
            'message' => $message,
            'request' => $request
        ]);
    }
    /**
     * @Route("/admin/user", name="admin_user")
     */
    public function GestionUser(EntityManagerInterface $manager, UserRepository $repo, Request $request): Response
    {
        $tableau = $manager->getClassMetadata(User::class)->getFieldNames(); // Métas données User

        dump($tableau);

        $user = $repo->findAll(); // Selectionne tout les Users

        dump($user);

        return $this->render('admin/gestion_user.html.twig', [
            'tableau' => $tableau,
            'user' => $user,
            'request' => $request
        ]);
    }

    /**
     * @Route("/admin/user/create", name="admin_user_create")
     * @Route("/admin/user/edit/{id}", name="admin_user_edit")
     */
    public function AjoutUser(User $user = null, Request $request, EntityManagerInterface $manager): Response
    // On rajoute = null car sinon symfony cherche a récupérer un pays en BDD
    // Request $request : récupère les données du formulaire dans la variable $request
    // EntityManagerInterface : Sert a manipuler la BDD
    {
        if(!$user) // Si le user selectionné n'est pas nul on fait alors une modification et on entre pas dans le IF
        {
            $user = new User;
        }

        // dump($request); // On controle les valeurs saisie
        // dump($user); // On controle si user est bien null

        $formUser = $this->createForm(InscriptionType::class, $user); // On créer le formulaire de UserType et on stock dans la variable $user

        $formUser->handleRequest($request); // Vérifie si tout les champs on été bien rempli et l'envoie dans le bon setter

        dump($request); 

        if($formUser->isSubmitted() && $formUser->isValid()) 
        {
            $manager->persist($user); // On maintient l'insertion en BDD dans la variable $user
            $manager->flush(); // On execute l'insertion

            $message = "L'utilisateur a bien été ajouté !!";

            $this->addFlash('success', "L'utilisateur a bien été ajouté !!");

            return $this->redirectToRoute('admin_user', [
                'id' => $user->getId() // On transmet le nouvel ID de l'user
            ]);
        }

        return $this->render('admin/user_create.html.twig', [
            'formUser' => $formUser->createView(), // on créer une vision dans la variable formUser
        ]);
    }
}
