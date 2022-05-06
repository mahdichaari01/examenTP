<?php

namespace App\Controller;

use App\Entity\Etudiant;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListAllController extends AbstractController
{
    #[Route('/list/all', name: 'app_list_all')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Etudiant::class);
        $etudiants=$repo->findAll();
        return $this->render('list_all/index.html.twig', [
            'controller_name' => 'ListAllController',
            'etudiants'=> $etudiants
        ]);
    }

}
