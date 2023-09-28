<?php

namespace App\Controller\api\lieu;

use App\Repository\LieuRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


class LieuController extends AbstractController
{
    #[Route('api/ville/{id}', name: 'app_ville', requirements: ['id' => '\d+'], methods: "GET")]
    public function index(LieuRepository $lieuRepository, $id): JsonResponse
    {
        $villes = $lieuRepository->findBy([
            'ville' => $id
        ]);
        return new JsonResponse($villes);


    }

    #[Route('api/coordonnee/{id}', name: 'app_lieu', requirements: ['id' => '\d+'], methods: "GET")]
    public function lieu(LieuRepository $lieuRepository, $id): JsonResponse
    {
        $lieu = $lieuRepository->findBy([
            'id' => $id
        ]);
        return new JsonResponse($lieu);

    }

    #[Route('api/code/{id}', name: 'app_code', requirements: ['id' => '\d+'], methods: "GET")]
    public function code(VilleRepository $villeRepository, $id): JsonResponse
    {
        $code = $villeRepository->findBy([
            'id' => $id
        ]);
        return new JsonResponse($code);
    }
    /**

     * @Route("/ajax/rechercheLieuByVille", name="rechercher_lieu_by_ville")

     */

        #[Route('api/lieu', name: 'app_ville')]
    public function rechercheAjaxByVille(Request $request , EntityManagerInterface $entityManager, LieuRepository  $lieuRepository){

        //declaration des variables

        $json_data = array();

        $i = 0;

        //recherche les lieux correspondant à la ville selectionnée

        $lieux = $lieuRepository->findBy(['ville' => $request->request->get('ville_id')]);

        //si lieux trouvées ...

        if(sizeof($lieux)> 0){

            //pour chaque lieu, hydratation d'un tableau

            foreach ($lieux as $lieu){

                $json_data[$i++] = array( 'id' => $lieu->getId(), 'nom' => $lieu->getNomLieu());

            }

            //renvoie un tableau au format json

            return new JsonResponse($json_data);

            //sinon (lieux non trouvé) ...

        }else{

            //hydratation du tableau avec : Pas de lieu correspondant à cette ville.

            $json_data[$i++] = array( 'id' => '', 'nom' => 'Pas de lieu correspondant à cette ville.');

            //renvoie un tableau au format json

            return new JsonResponse($json_data);

        }

    }
}
