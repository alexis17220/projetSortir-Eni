<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantMDPType;
use App\Form\ProfilType;
use App\Repository\ParticipantRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantController extends AbstractController
{
    /**
     * @param ParticipantRepository $participantRepository
     * @param $id
     * @return Response
     *
     * Fonction permettant d'afficher profil de l'utilisateur
     */
    #[Route('/profil/{id}', name: 'app_profil', requirements: ['id' => '\d+'])]
    public function affiche(ParticipantRepository $participantRepository, $id = null)
    {
        $participant = $participantRepository->find($id);

        return $this->render('profil/affiche.html.twig', [
            'participant' => $participant,
        ]);
    }

    /**
     * @param ParticipantRepository $participantRepository
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return Response
     *
     * Fonction permettant de modifier son profil
     */

    #[Route('/gererProfil/{id}', name: 'app_gerer_profil', requirements: ['id' => '\d+'])]
    public function gerer(ParticipantRepository $participantRepository, FileUploader $fileUploader, Request $request, EntityManagerInterface $entityManager, $id = null): Response
    {

        if ($request->attributes->get('_route') == 'app_admin_agent_ajouter') {
            $participant = new Participant();


        } else {
            $participant = $participantRepository->find($id);
            $password = $participant->getPassword();
            $idParticipant = $participant->getId();
        }


        $form = $this->createForm(ProfilType::class, $participant);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $participant->setId($idParticipant);
            $participant->setPassword($password);
            $participant->setAdministrateur(false);
            /** @var UploadedFile $photo */
            $photo = $form->get('urlPhoto')->getData();
            if ($photo) {
                $photoFileName = $fileUploader->upload($photo);
                $participant->setUrlPhoto($photoFileName);
            }
            $participant->setActif(true);
            $participant->setRoles(['ROLE_USER']);
            $entityManager->persist($participant);
            $entityManager->flush();
            if ($request->attributes->get('_route') == 'app_gerer_profil') {

                $message = 'Vous avez modifier votre profil avec succès';
            }
            $this->addFlash(
                'notice',
                $message,

            );
            return $this->redirectToRoute('app_accueil');
        }


        return $this->render('profil/gerer.html.twig', ['participant'=>$participant, 'form' => $form->createView(),]);
    }
    #[Route('/changer_mdp/{id}', name: 'app_mdp', requirements: ['id' => '\d+'])]
    public function mdp(UserPasswordHasherInterface $hasher, ParticipantRepository $participantRepository, Request $request, EntityManagerInterface $entityManager, $id = null): Response
    {

        $participant = $participantRepository->find($id);

        $form = $this->createForm(ParticipantMDPType::class, $participant);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $participant->setPassword($hasher->hashPassword($participant, $participant->getPassword()));
            $entityManager->persist($participant);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Vous avez modifier votre mot de passe avec succès.',

            );
            return $this->redirectToRoute('app_accueil');
        }


        return $this->render('profil/mdp.html.twig', ['participant'=>$participant, 'form' => $form->createView(),]);
    }
}
