<?php

namespace App\Controller\admin;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\EtatRepository;
use App\Repository\ParticipantRepository;
use App\Repository\SiteRepository;
use App\Repository\SortieRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SortieController extends AbstractController
{
    /**
     * @param SortieRepository $sortieRepository
     * @return Response
     *
     *Fonction permettant d'afficher liste des sorties sour forme de tableau
     */
    #[Route('/admin/sortie', name: 'app_admin_sortie_liste')]
    public function index(SortieRepository $sortieRepository): Response
    {
//si l agent est admin, il voit tous les sortie
            $sortie = $sortieRepository->findAll();

        return $this->render('admin/sortie/sortie.html.twig', [
            'sortie' => $sortie,
        ]);

    }

    /**
     * @param Request $request
     * @param SortieRepository $sortieRepository
     * @param VilleRepository $villeRepository
     * @param EtatRepository $etatRepository
     * @param ParticipantRepository $participantRepository
     * @param SiteRepository $siteRepository
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return Response
     *
     * Fonction permettant de publié une sortie
     * et de modifier la sortie en fonction de l'id dans le meme formulaire remplie des informations saisie
     */

    #[Route('/Sorties/ajouter', name: 'app_admin_sortie_ajout')]
    #[Route('/Sorties/modifier/{id}', name: 'app_admin_sortie_modifier', requirements: ['id' => '\d+'])]

    public function editer(Request $request, SortieRepository $sortieRepository, VilleRepository $villeRepository, EtatRepository $etatRepository, ParticipantRepository $participantRepository, SiteRepository $siteRepository,EntityManagerInterface $entityManager, $id = null): Response
    {

        //recuperation de toute les villes
        $ville=$villeRepository->findAll();

        //recuperation de l id de l'utilisateur connecté
        $participant=$this->getUser();
        //ajout
        if ($request->attributes->get('_route') == 'app_admin_sortie_ajout') {
            //création de nouvelle sortie
            $sortie = new Sortie();
            //nouvelle etat juste ouvert quand c'est publié
            $etat = $etatRepository->find(2);
            $sortie->setEtat($etat);
        } else {
            //modifier
            $sortie = $sortieRepository->find($id);

            //si l'utilisateur n'a pas créer la sortie alors il ne peut pas modifier la sortie
            if ($sortie->getParticipant() != $this->getUser() && !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
                $message2 = 'Ceci n\'est pas votre sortie';

                $this->addFlash(
                    'alerte',
                    $message2,

                );
                return $this->redirectToRoute('app_admin_sortie_liste');
            }
        }

        //création du formulaire de sortie avec SortieType
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

//        dd($request, $_POST, $sortie);

        //quand le formulaire est valide et conforme
        if ($form->isSubmitted() && $form->isValid()) {

            //id participant
            $sortie->setParticipant($this->getUser());

            //id site
            $participant=$participantRepository->find($this->getUser()->getSite());
            $site=$siteRepository->find($participant);
            $sortie->setSite($site);

            $entityManager->persist($sortie);
            $entityManager->flush();
            if ($request->attributes->get('_route') == 'app_admin_sortie_ajout') {

                $message = 'Votre sortie a été publier avec succèes';
            } else {
                $message = 'Votre sortie a été modifier avec succèes';
            }
            $this->addFlash(
                'notice',
                $message,

            );

            if($participant->getRoles()=="ROLE_ADMIN") {
                return $this->redirectToRoute('app_admin_sortie_liste');
            }else {
                return $this->redirectToRoute('app_sorties');
            }
        }
//dd($ville);
        return $this->render('admin/sortie/editerSortie.html.twig', [
            'form' => $form->createView(),
            'participant'=>$participant,
            'villes' => $ville,
            'sorties'=> $sortie


        ]);
    }


    /**
     * @param Request $request
     * @param SortieRepository $sortieRepository
     * @param VilleRepository $villeRepository
     * @param EtatRepository $etatRepository
     * @param ParticipantRepository $participantRepository
     * @param SiteRepository $siteRepository
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return Response
     *
     *Fonction permettant d'enregistrer la sortie
     */
//    #[Route('/Sortie/save', name: 'app_sortie_save')]
////    #[Route('/sortie/modifier/{id}', name: 'app_sortie_modifier', requirements: ['id' => '\d+'])]
//
//    public function save(Request $request, SortieRepository $sortieRepository, VilleRepository $villeRepository, EtatRepository $etatRepository, ParticipantRepository $participantRepository, SiteRepository $siteRepository,EntityManagerInterface $entityManager, $id = null): Response
//    {
//
//        $ville=$villeRepository->findAll();
//        $participant=$this->getUser();
//        //ajout
//        if ($request->attributes->get('_route') == 'app_sortie_save') {
//            $sortie = new Sortie();
//            //nouvelle etat juste crée
//            $etat = $etatRepository->find(1);
//            $sortie->setEtat($etat);
//        } else {
//            //modifier
//            $sortie = $sortieRepository->find($id);
//            if ($sortie->getParticipant() != $this->getUser() && !in_array('ROLE_USER', $this->getUser()->getRoles())) {
//                $message2 = 'Ceci n\'est pas votre sortie';
//
//                $this->addFlash(
//                    'alerte',
//                    $message2,
//
//                );
//                return $this->redirectToRoute('app_sorties');
//            }
//        }
//
//        $form = $this->createForm(SortieType::class, $sortie);
//        $form->handleRequest($request);
//
//        //dd($request);
////        dd($request, $_POST, $sortie);
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            //id participant
//            $sortie->setParticipant($this->getUser());
//
//            //id site
//            $participant=$participantRepository->find($this->getUser()->getSite());
//            $site=$siteRepository->find($participant);
//            $sortie->setSite($site);
//
//            $entityManager->persist($sortie);
//            $entityManager->flush();
//            if ($request->attributes->get('_route') == 'app_sortie_save') {
//
//                $message = 'Votre sortie a été publier avec succèes';
//            } else {
//                $message = 'Votre sortie a été modifier avec succèes';
//            }
//            $this->addFlash(
//                'notice',
//                $message,
//
//            );
//
//                return $this->redirectToRoute('app_sorties');
//
//        }
//
//
////dd($ville);
//        return $this->render('admin/sortie/editerSortie.html.twig', [
//            'form' => $form->createView(),
//            'participant'=>$participant,
//            'villes' => $ville,
//
//
//        ]);
//    }

}
