<?php

namespace App\Controller\api;

use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FiltreSortieController extends AbstractController
{



    #[Route('/api/sortielist/{id}', name: 'app_sorties_list', methods: 'GET')]
    public function filtre(SortieRepository $sortieRepository, Request $request,$id): Response
    {

        if ($id == 'tout') {
            $sorties = $sortieRepository->findAll();

        } else {
        $sorties = $sortieRepository->findBy([
            "site" => $id,
        ]);

           }
        return new Response($this->renderView('public/sortielist.html.twig',[
                "sorties"=>$sorties,
        ]));
    }
}
