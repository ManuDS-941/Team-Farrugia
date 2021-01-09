<?php

namespace App\Controller;

use DateTime;
use App\Entity\Site;
use App\Entity\User;
use App\Entity\Tarif;
use App\Form\SiteType;
use App\Entity\Accueil;
use App\Entity\Horaire;
use App\Entity\Message;
use App\Form\TarifType;
use App\Form\AccueilType;
use App\Form\HoraireType;
use App\Entity\Information;
use App\Form\InscriptionType;
use App\Repository\SiteRepository;
use App\Repository\UserRepository;
use App\Repository\TarifRepository;
use App\Repository\AccueilRepository;
use App\Repository\HoraireRepository;
use App\Repository\MessageRepository;
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
    public function index(Request $request, MessageRepository $repo): Response
    {
        $message = $repo->findAll();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'request' => $request,
            'message' => $message,
        ]);
    }
    /**
     * @Route("/admin/accueil", name="admin_accueil")
     */
    public function GestionAccueil(Request $request, MessageRepository $repo, EntityManagerInterface $manager, AccueilRepository $repo1): Response
    {

        $tableau = $manager->getClassMetadata(Accueil::class)->getFieldNames();

        $message = $repo->findAll();
        $accueil = $repo1->findAll();

        dump($accueil);
        dump($request);

        return $this->render('admin/gestion_accueil.html.twig', [
            'request' => $request,
            'message' => $message,
            'tableau' => $tableau,
            'accueil' => $accueil
        ]);
    }

    /**
     * @Route("/admin/accueil/create", name="admin_accueil_create")
     * @Route("/admin/accueil/edit/{id}", name="admin_accueil_edit")
     */
    public function AjoutAccueil(Accueil $accueil = null, Request $request, EntityManagerInterface $manager): Response
    {
        if(!$accueil)
        {
            $accueil = new Accueil;
        }

        $formAccueil = $this->createForm(AccueilType::class, $accueil);

        $formAccueil->handleRequest($request);
        
        dump($request);

        if( $formAccueil->isSubmitted() && $formAccueil->isValid())
        {
            if(!$accueil->getId())
            {
                $accueil->setCreatedAt(new \DateTime());
            }
            
            $manager->persist($accueil);
            $manager->flush();

            $this->addFlash('success', "L'article a bien été ajouté !!");

            return $this->redirectToRoute('admin_accueil', [
                'id' => $accueil->getId() // On transmet le nouvel ID
            ]);
        }


        return $this->render('admin/accueil_create.html.twig', [
            'formAccueil' => $formAccueil->createView()
        ]);
    }
    /**
     * @Route("/admin/accueil/delete/{id}", name="admin_accueil_delete")
     */
    public function DeleteAccueil(EntityManagerInterface $manager, Accueil $accueil)
    {
        $manager->remove($accueil);
        $manager->flush();

        $this->addFlash('success', "L'article de l'accueil a bien été supprimé");

        $this->redirectToRoute('admin_accueil');
    }

    /**
     * @Route("/admin/medias", name="admin_medias")
     */
    public function GestionMédias(Request $request, MessageRepository $repo): Response
    {
        $message = $repo->findAll();

        return $this->render('admin/gestion_medias.html.twig', [
            'controller_name' => 'AdminController',
            'request' => $request,
            'message' => $message,
        ]);
    }

    /**
     * @Route("/admin/info", name="admin_info")
     */
    public function GestionInformations(Request $request, MessageRepository $repo, EntityManagerInterface $manager, HoraireRepository $repo1, TarifRepository $repo2, SiteRepository $repo3): Response
    {
        $message = $repo->findAll();

        $tableau = $manager->getClassMetadata(Horaire::class)->getFieldNames();
        $tableau1 = $manager->getClassMetadata(Tarif::class)->getFieldNames();
        $tableau2 = $manager->getClassMetadata(Site::class)->getFieldNames();
        // dump($tableau);
        dump($request);

        $horaire = $repo1->findAll();
        //dump($horaire);
        $tarif = $repo2->findAll();
        //dump($tarif);
        $site = $repo3->findAll();
        //dump($site);

        
        return $this->render('admin/gestion_info.html.twig', [
            'request' => $request,
            'message' => $message,
            'tableau' => $tableau,
            'tableau1' => $tableau1,
            'tableau2' => $tableau2,
            'horaire' => $horaire,
            'tarif' => $tarif,
            'site' => $site
        ]);
    }

    /**
     * @Route("/admin/horaire/create", name="admin_horaire_create")
     * @Route("/admin/horaire/edit/{id}", name="admin_horaire_edit")
     */
    public function AjoutHoraire(Horaire $horaire = null, Request $request, EntityManagerInterface $manager): Response
    {
        if(!$horaire)
        {
            $horaire = new Horaire;
        }

        $formHoraire = $this->createForm(HoraireType::class, $horaire);

        $formHoraire->handleRequest($request);

        dump($request);

        
        if($formHoraire->isSubmitted() && $formHoraire->isValid())
        {
            
            $manager->persist($horaire);
            $manager->flush();

            $this->addFlash('success', "L'horaire a bien été ajouté !!");

            return $this->redirectToRoute('admin_info', [
                'id' => $horaire->getId() // On transmet le nouvel ID
            ]);
        }

        return $this->render('admin/admin_horaire_create.html.twig', [
            'formHoraire' => $formHoraire->createView()
        ]);
    }

    /**
     * @Route("/admin/horaire/delete/{id}", name="admin_horaire_delete")
     */
    public function DeleteHoraire(EntityManagerInterface $manager, Horaire $horaire)
    {
        $manager->remove($horaire);
        $manager->flush();

        $this->addFlash('success', "L'horaire a bien été supprimé");

        $this->redirectToRoute('admin_info');
    }

    /**
     * @Route("/admin/tarif/create", name="admin_tarif_create")
     * @Route("/admin/tarif/edit/{id}", name="admin_tarif_edit")
     */
    public function AjoutTarif(Tarif $tarif = null, Request $request, EntityManagerInterface $manager): Response
    {
        if(!$tarif)
        {
            $tarif = new Tarif;
        }

        $formTarif = $this->createForm(TarifType::class, $tarif);

        $formTarif->handleRequest($request);

        dump($request);

        if($formTarif->isSubmitted() && $formTarif->isValid())
        {
            $manager->persist($tarif);
            $manager->flush();

            $this->addFlash('success', "Le tarif a bien été ajouté !!");

            return $this->redirectToRoute('admin_info', [
                'id' => $tarif->getId() // On transmet le nouvel ID
            ]);
        }

        return $this->render('admin/admin_tarif_create.html.twig',[
            'formTarif' => $formTarif->createView()
        ]);
    }

    /**
     * @Route("/admin/tarif/delete/{id}", name="admin_tarif_delete")
     */
    public function DeleteTarif(EntityManagerInterface $manager, Tarif $tarif)
    {
        $manager->remove($tarif);
        $manager->flush();

        $this->addFlash('success', "Le tarif a bien été supprimé");

        return $this->redirectToRoute('admin_info');
    }

    /**
     * @Route("/admin/site/create", name="admin_site_create")
     * @Route("/admin/site/edit/{id}", name="admin_site_edit")
     */
    public function AjoutSite(Site $site = null, Request $request, EntityManagerInterface $manager): Response
    {
        if(!$site)
        {
            $site = new Site;
        }

        $formSite = $this->createForm(SiteType::class, $site);

        $formSite->handleRequest($request);

        dump($request);

        if($formSite->isSubmitted() && $formSite->isValid())
        {
            $manager->persist($site);
            $manager->flush();

            $this->addFlash('success', "Le site a bien été ajouté !!");

            return $this->redirectToRoute('admin_info', [
                'id' => $site->getId() // On transmet le nouvel ID
            ]);
        }

        return $this->render('admin/admin_site_create.html.twig', [
            'formSite' => $formSite->createView()
        ]);
    }

    /**
     * @Route("/admin/site/delete/{id}", name="admin_site_delete")
     */
    public function DeleteSite(EntityManagerInterface $manager, Site $site)
    {
        $manager->remove($site);
        $manager->flush();

        $this->addFlash('success', "Le site a bien été supprimé");

        return $this->redirectToRoute('admin_info');
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
     * @Route("/admin/message/delete/{id}", name="admin_message_delete")
     */
    public function DeleteMessage(Message $message, EntityManagerInterface $manager)
    {
        $manager->remove($message);
        $manager->flush();

        $this->addFlash('success', "Le message a bien été supprimé");

        $this->redirectToRoute('admin_message');
    }
    /**
     * @Route("/admin/user", name="admin_user")
     */
    public function GestionUser(EntityManagerInterface $manager, UserRepository $repo, Request $request, MessageRepository $repo1): Response
    {
        $tableau = $manager->getClassMetadata(User::class)->getFieldNames(); // Métas données User

        dump($tableau);

        $user = $repo->findAll(); // Selectionne tout les Users

        dump($user);

        $message = $repo1->findAll(); // Selectionne tout les messages pour voir si il y a un nouveau message sur le menu admin

        return $this->render('admin/gestion_user.html.twig', [
            'tableau' => $tableau,
            'user' => $user,
            'request' => $request,
            'message' => $message,
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

    /**
     * @Route("/admin/user/delete/{id}", name="admin_user_delete")
     */
    public function DeleteUser(User $user, EntityManagerInterface $manager)
    {
        $manager->remove($user);
        $manager->flush();

        $this->addFlash('success', "L'utilisateur a bien été supprimé");

        $this->redirectToRoute('admin_user');
    }
}
