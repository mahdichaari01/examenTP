<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Section;
use App\Form\EtudiantType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddController extends AbstractController
{
    #[Route('/add', name: 'app_add_get', methods: ['GET'])]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Section::class);
        $section=$repo->findAll();
        return $this->render('add/index.html.twig', [
            "sections" => $section
        ]);

    }

    #[Route('/add', name: 'app_add_post', methods: ['POST'])]
    public function index2(ManagerRegistry $doctrine, ):Response{
        //services syfony
        $request = Request::createFromGlobals()->request;
        $repo = $doctrine->getRepository(Section::class);
        $manager=$doctrine->getManager();

        //traitement de donnéé
        $nom=$request->get('nom');
        $prenom=$request->get('prenom');
        $section=intval($request->get("section"));

        //donnée invalide
        if($nom==null || $prenom==null){
            $this->addFlash("warning","donnée insuffisant");
            return $this->redirectToRoute("app_add_get");
        }

        //creation d'instance
        $new = new Etudiant();
        $new->setPrenom($prenom);
        $new->setNom($nom);
        $new->setSection($repo->find($section));
        $manager->persist($new);
        $manager->flush();

        $this->addFlash("info", "ajout d'étudiant effectué avec succes");
        return $this->redirectToRoute("app_list_all");

    }
}
