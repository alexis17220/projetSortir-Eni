<?php

namespace App\Controller\admin;

use App\Entity\Participant;
use App\Form\ParticipantNoMDPType;
use App\Form\ParticipantType;
use App\Repository\ParticipantRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    /**
     * @param ParticipantRepository $participantRepository
     * @return Response
     * liste de tous les utilisateurs
     */
    #[Route('/admin/utilisateur', name: 'app_admin_user')]
    public function listUser(ParticipantRepository $participantRepository): Response
    {
        $participants = $participantRepository->findAll();

        return $this->render('admin/utilisateur/utilisateur.html.twig', [
            'participants' => $participants,
        ]);
    }

    /**
     * @param UserPasswordHasherInterface $hasher
     * @param ParticipantRepository $participantRepository
     * @param FileUploader $fileUploader
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return Response
     * ajout d'un utilisateur
     */
    #[Route('/admin/ajouterUtilisateur', name: 'app_admin_add_user')]
    public function ajouter(UserPasswordHasherInterface $hasher, ParticipantRepository $participantRepository, FileUploader $fileUploader, Request $request, EntityManagerInterface $entityManager, $id = null): Response
    {

        //nouveau participant
        $participant = new Participant();
        $participant->setRoles(["ROLE_USER"]);

        $form = $this->createForm(ParticipantNoMDPType::class, $participant);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $photo */
            $photo = $form->get('urlPhoto')->getData();
            if ($photo) {
                $photoFileName = $fileUploader->upload($photo);
                $participant->setUrlPhoto($photoFileName);
            }

            //password par défaut
            $participant->setPassword($hasher->hashPassword($participant, "password"));
            $participant->setActif(true);
            $participant->setAdministrateur(false);

            $entityManager->persist($participant);
            $entityManager->flush();
            if ($request->attributes->get('_route') == 'app_admin_add_user') {

                $message = 'Votre Utilisateur a été enregistrer avec succèes';
            }
            $this->addFlash(
                'notice',
                $message,

            );
            return $this->redirectToRoute('app_admin_user');
        }


        return $this->render('admin/utilisateur/editUtilisateur.html.twig', ['form' => $form->createView(),]);
    }

    /**
     * @param UserPasswordHasherInterface $hasher
     * @param ParticipantRepository $participantRepository
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return Response
     *
     * modification de l'utilisateur
     */
    #[Route('/admin/modifierUtilisateur/{id}', name: 'app_admin_modify_user', requirements: ['id' => '\d+'])]
    public function editer(UserPasswordHasherInterface $hasher, ParticipantRepository $participantRepository, Request $request, EntityManagerInterface $entityManager, $id = null): Response
    {

        $participant = $participantRepository->find($id);

        $form = $this->createForm(ParticipantNoMDPType::class, $participant);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($participant);
            $entityManager->flush();
            if ($request->attributes->get('_route') == 'app_admin_modify_user') {

                $message = 'Votre Utilisateur a été modifier avec succèes';
            }
            $this->addFlash(
                'notice',
                $message,

            );
            return $this->redirectToRoute('app_admin_user');
        }


        return $this->render('admin/utilisateur/editUtilisateur.html.twig', ['form' => $form->createView(),]);
    }

    /**
     * @param ParticipantRepository $participantRepository
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return Response
     * suppression de l'utilisateur
     */
    #[Route('/SupprimerUtilisateur/{id}', name: 'app_admin_del_user')]
    public function delUtilisateur(ParticipantRepository $participantRepository, EntityManagerInterface $entityManager, $id = null): Response
    {
        $participant = $participantRepository->find($id);
        if ($participant) {
            $entityManager->remove($participant);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                "L'utilisateur a été supprimer avec succès",
            );
        }
        return $this->redirectToRoute('app_admin_user');

    }


}
