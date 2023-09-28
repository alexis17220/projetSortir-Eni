<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use App\Entity\Inscription;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }


    public function load(ObjectManager $manager): void
    {

        // Initialisation des données aléatoire pour un remplissage auto
        $faker = Faker\Factory::create();

        //Création de tout les états possible
        // Créée
        $etat = new Etat();
        $etat->setNoEtat(1);
        $etat->setLibelle('Créée');
        $manager->persist($etat);
        // En cours
        $etat = new Etat();
        $etat->setNoEtat(2);
        $etat->setLibelle('En cours');
        $manager->persist($etat);
        // Ouverte
        $etat = new Etat();
        $etat->setNoEtat(3);
        $etat->setLibelle('Ouverte');
        $manager->persist($etat);
        //Clôturée
        $etat = new Etat();
        $etat->setNoEtat(4);
        $etat->setLibelle('Clôturée');
        $manager->persist($etat);
        // Activité en cours
        $etat = new Etat();
        $etat->setNoEtat(5);
        $etat->setLibelle('Activité en cours');
        $manager->persist($etat);
        // passée
        $etat = new Etat();
        $etat->setNoEtat(6);
        $etat->setLibelle('Passée');
        $manager->persist($etat);
        // Annulée
        $etat = new Etat();
        $etat->setNoEtat(7);
        $etat->setLibelle('Annulée');
        $manager->persist($etat);


        //creation ville
        for($i = 0; $i <10 ; $i++){

            //Création de 10 villes
            $ville = new Ville();
            $ville->setNomVille($faker->name);
            $ville->setCodePostal($faker->randomDigit());

            $manager->persist($ville);

            //Création de 10 lieu
            $lieu = new Lieu();
            $lieu->setNomLieu($faker->name);
            $lieu->setRue($faker->name);
            $lieu->setLatitude($faker->randomFloat());
            $lieu->setLongitude($faker->randomFloat());
            //Ville = celle créer précédement
            $lieu->setVille($ville);
            $manager->persist($lieu);

            //Création de 10 site
            $site = new Site();
            $site->setNomSite($faker->name);
            $manager->persist($site);

            //Créer 10 Participants ADMIN
            $participant = new Participant();
            $participant->setPseudo($faker->name);
            $participant->setNom($faker->name);
            $participant->setPrenom($faker->name);
            $participant->setEmail('admin'.$i.'@gmail.com');
            $participant->setTelephone($faker->phoneNumber);
            $participant->setRoles(["ROLE_ADMIN"]);
            $password = $this->hasher->hashPassword($participant,'test');
            $participant->setPassword($password);
            $participant->setAdministrateur(1);
            $participant->setActif(1);
            $participant->setSite($site);
            $manager->persist($participant);

            //Créer 10 Participant USER
            $participant = new Participant();
            $participant->setPseudo($faker->name);
            $participant->setNom($faker->name);
            $participant->setPrenom($faker->name);
            $participant->setEmail('user'.$i.'@gmail.com');
            $participant->setTelephone($faker->phoneNumber);
            $participant->setRoles(["ROLE_USER"]);
            $password = $this->hasher->hashPassword($participant,'test');
            $participant->setPassword($password);
            $participant->setAdministrateur(0);
            $participant->setActif(1);
            $participant->setSite($site);
            $manager->persist($participant);

            //Création de 10 inscription
            $inscription = new Inscription();
            $inscription->setDateInscription($faker->dateTime);
            $manager->persist($inscription);

            //Création de 10 sorties
            $sortie = new Sortie();
            $sortie->setNom($faker->name);
            $sortie->setDateDebut($faker->dateTime);
            $sortie->setDuree($faker->randomDigit());
            $sortie->setDateCloture($faker->dateTime);
            $sortie->setDescriptionInfo($faker->realText);
            $sortie->setNbInscriptionMax($faker->randomDigit());
            $sortie->setUrlPhoto($faker->realText);
            //Attribution d'un lieu
            $sortie->setLieu($lieu);
            //Attribution d'un état
            $sortie->setEtat($etat);
            //Attribution d'un participant
            $sortie->setParticipant($participant);
            //Attribution d'un site
            $sortie->setSite($site);
            $manager->persist($sortie);


        }
        $manager->flush();



    }
}
