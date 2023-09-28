<?php

namespace App\Controller;


use App\Form\RechercheType;
use App\Repository\EtatRepository;
use App\Repository\ParticipantRepository;
use App\Repository\SiteRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class SortieController extends AbstractController
{
    /**
     * @param UserInterface $user
     * @param ParticipantRepository $participantRepository
     * @param SortieRepository $sortieRepository
     * @return Response
     *
     * Fonction permettant d'affiche la page d'accueil si utilisateur a pour role user et il voit les sorties du site dont il est affecté
     */
    #[Route('/Accueil', name: 'app_accueil')]
    public function accueil(UserInterface $user, ParticipantRepository $participantRepository, SortieRepository $sortieRepository): Response
    {

        $id = $user->getId();
        $participant = $participantRepository->find($id);
        $site = $participant->getSite();
        $sorties = $sortieRepository->findBy(
            ["site" => $site->getId()],
        );

        return $this->render('public/accueil.html.twig', [
            "participant" => $participant,
            "id" => $id,
            "site" => $site,
            "sorties" => $sorties,

        ]);

    }

    /**
     * @param SortieRepository $sortieRepository
     * @param SiteRepository $siteRepository
     * @param EtatRepository $etatRepository
     * @param Request $request
     * @param $id
     * @return Response
     *
     * Fonction permettant d'affiché toutes les sorties
     */
    #[Route('/Sorties', name: 'app_sorties')]
    public function sorties(SortieRepository $sortieRepository, SiteRepository $siteRepository, EtatRepository $etatRepository, Request $request, $id = null): Response
    {
        $sites = $siteRepository->findAll();
        $sorties = $sortieRepository->findAll();
        $etats = $etatRepository->findAll();

        if (in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            return $this->render('admin/sortie/sortie.html.twig', [
                'sortie' => $sorties,
            ]);
        }


        return $this->render('public/sorties.html.twig', [
            "sorties" => $sorties,
            'sites' => $sites,
            'etats' => $etats

        ]);

    }

    /**
     * @param Request $request
     * @param SiteRepository $siteRepo
     * @param EtatRepository $etatRepo
     * @param SortieRepository $sortieRepo
     * @return Response
     * @throws \Exception
     *
     * Fonction permettant de d'afficher les sorties repondant aux critères de filtre
     * @Route("/Sorties", name="sortie_liste")
     */
    public function liste(Request $request, SiteRepository $siteRepo, EtatRepository $etatRepo, SortieRepository $sortieRepo)
    {
        //Si l'utilisateur n'est pas encore connecté, il lui sera demandé de se connecter (par exemple redirigé vers la page de connexion).
        //Si l'utilisateur est connecté, mais n'a pas le rôle ROLE_USER, il verra la page 403 (accès refusé) … il faudra créer de belles pages d’erreur 404 et 403 visible en prod
        $this->denyAccessUnlessGranted('ROLE_USER');

        //appel de la methode rechercheDetaillee dans SortieRepository afin de recupérer les sorties filtrées
        $sortiesQuery = $sortieRepo->rechercheDetaillee(
            ($request->query->get('recherche_terme') != null ? $request->query->get('recherche_terme') : null),
            ($request->query->get('recherche_site') != null ? $request->query->get('recherche_site') : null),
            ($request->query->get('recherche_etat') != null ? $request->query->get('recherche_etat') : null),
            ($request->query->get('date_debut') != null ? $request->query->get('date_debut') : null),
            ($request->query->get('date_fin') != null ? $request->query->get('date_fin') : null),
            ($request->query->get('cb_organisateur') != null ? $request->query->get('cb_organisateur') : null),
            ($request->query->get('cb_inscrit') != null ? $request->query->get('cb_inscrit') : null),
            ($request->query->get('cb_non_inscrit') != null ? $request->query->get('cb_non_inscrit') : null),
            ($request->query->get('cb_passee') != null ? $request->query->get('cb_passee') : null)
        );

        //recuperation de tous les sites
        $sites = $siteRepo->findAll();
        //recuperation de tous les etats
        $etats = $etatRepo->findAll();
        $sorties = $sortieRepo->findAll();

        if (in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            return $this->render('admin/sortie/sortie.html.twig', [
                'sortie' => $sorties,
            ]);
        }
        //délégation du travail au twig liste.html.twig en y passant en parametre les sorties filtrées, les sites et les etats
        return $this->render("public/sorties.html.twig", [
            'sorties' => $sortiesQuery,
            'sites' => $sites,
            'etats' => $etats
        ]);
    }

    /**
     * @param SortieRepository $sortieRepository
     * @param SiteRepository $siteRepository
     * @param ParticipantRepository $participantRepository
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param $id
     * @return Response
     *
     * Fonction permettant l'inscription de l'utilisateur a la sortie via l'id de la sortie
     */
    #[Route('/inscriptionSortie/{id}', name: 'app_inscriptionSortie')]
    public function inscriptionSorties(SortieRepository $sortieRepository, SiteRepository $siteRepository,EtatRepository $etatRepository, EntityManagerInterface $entityManager, Request $request, $id = null): Response
    {
        $sites = $siteRepository->findAll();
        $sorties = $sortieRepository->findAll();
        $etats = $etatRepository->findAll();

        if (in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            $message2 = 'Vous ne pouvez pas vous inscrire en tant qu\'administrateur du site';

            $this->addFlash(
                'alerte',
                $message2,

            );
            return $this->redirectToRoute('app_accueil');
        }
        $sortie = $sortieRepository->findOneBySomeid($id);
        $sortie->addParticipant($this->getUser());
        $entityManager->persist($sortie);
        $entityManager->flush();
        $this->addFlash(
            'notice',
            'vous êtes inscrit a la sortie avec succèes',
        );
        return $this->render('public/sorties.html.twig', [
            "sorties" => $sorties,
            'sites' => $sites,
            'etats'=>$etats
        ]);
    }

    /**
     * @param SortieRepository $sortieRepository
     * @param SiteRepository $siteRepository
     * @param ParticipantRepository $participantRepository
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param $id
     * @return Response
     *
     * Fonction permettant de desisté a la sortie en recuperant l id quand l'utilisateur est inscrit
     */
    #[Route('/desisterSortie/{id}', name: 'app_desisterSortie')]
    public function desisterSorties(SortieRepository $sortieRepository, SiteRepository $siteRepository, EtatRepository $etatRepository, EntityManagerInterface $entityManager, Request $request, $id = null): Response
    {
        $sites = $siteRepository->findAll();
        $sorties = $sortieRepository->findAll();
        $etats = $etatRepository->findAll();


        $sortie = $sortieRepository->findOneBySomeid($id);
        $sortie->removeParticipant($this->getUser());
        $entityManager->persist($sortie);
        $entityManager->flush();
        $this->addFlash(
            'notice',
            'vous êtes désister de la sortie avec succèes',
        );
        return $this->render('public/sorties.html.twig', [
            "sorties" => $sorties,
            'sites' => $sites,
            'etats'=>$etats
        ]);
    }

    /**
     * @param Request $request
     * @param SortieRepository $sortieRepository
     * @param ParticipantRepository $participantRepository
     * @param $id
     * @return Response
     *
     * Fonction permettant d'afficher les détail de la sortie avec les participants inscrit
     */

    #[Route('/Sorties/{id}', name: 'app_sorties_info', requirements: ['id' => '\d+'])]
    public function info(Request $request, SortieRepository $sortieRepository, ParticipantRepository $participantRepository, $id = null): Response
    {

        $sortie = $sortieRepository->find($id);
        //utilisation de l id utilisateur
        $participant = $participantRepository->find($this->getUser());
        return $this->render('public/infoSortie.html.twig', [
            "sorties" => $sortie,
            "participant" => $participant
        ]);

    }

    /**
     * @param SortieRepository $sortieRepository
     * @param $id
     * @return Response
     *
     * Fonction permettant de faire la demande d'annulation la sortie
     */
    #[Route('/Sorties/demandeAnnulation/{id}', name: 'app_sorties_demande_annulation', requirements: ['id' => '\d+'])]
    public function demandeAnnulation(SortieRepository $sortieRepository, $id = null): Response
    {

        //recupere l id de la sortie
        $sortie = $sortieRepository->find($id);

        //verification si la sortie appartient bien a l organisateur
        if ($sortie->getParticipant() != $this->getUser() && !in_array('ROLE_ADMIN', $this->getUser()->getRoles()) || !in_array('ROLE_USER', $this->getUser()->getRoles())) {
            $message2 = 'Ceci n\'est pas votre sortie';

            $this->addFlash(
                'notice',
                $message2,

            );

            return $this->redirectToRoute('app_sorties');
        }
        return $this->render('public/annulationSortie.html.twig', [
            "sorties" => $sortie,
        ]);

    }

    /**
     * @param Request $request
     * @param SortieRepository $sortieRepository
     * @param EntityManagerInterface $entityManager
     * @param EtatRepository $etatRepository
     * @param $id
     * @return Response
     * Fonction permettant d'annulé la sortie
     */
    #[Route('/Sorties/annulationSortie/{id}', name: 'app_annulationSortie')]
    public function annulationSortie(Request $request, SortieRepository $sortieRepository, EntityManagerInterface $entityManager, EtatRepository $etatRepository, $id = null): Response
    {

        $sortie = $sortieRepository->find($id);
        if ($sortie->getParticipant() != $this->getUser() && !in_array('ROLE_ADMIN', $this->getUser()->getRoles()) || !in_array('ROLE_USER', $this->getUser()->getRoles())) {
            $message2 = 'Ceci n\'est pas votre sortie';

            $this->addFlash(
                'notice',
                $message2,

            );

            return $this->redirectToRoute('app_sorties');
        }
        if ($sortie) {

//           dd($request,$request->query->get('motif'));
            $etat = $etatRepository->find(6);
            $sortie->setEtat($etat);
            $sortie->setMotif($_POST['motif']);
            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash(
                'alerte',
                'Votre sortie a été annuler avec succèes',
            );
        }

        return $this->redirectToRoute('app_sorties');
    }
}
