<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Section;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController
{
    #[Route('/edit/{slug}', name: 'app_edit_get',methods: ['GET'])]
    public function index(ManagerRegistry $doctrine,$slug): Response
    {
        $repo = $doctrine->getRepository(Section::class);
        $section=$repo->findAll();
        $repo=$doctrine->getRepository(Etudiant::class);
        $etudiant=$repo->find(intval($slug));
        return $this->render('edit/index.html.twig', [
            "sections" => $section,
            "etudiant" => $etudiant
        ]);
    }


    #[Route('/edit/{slug}', name: 'app_edit_post', methods: ['POST'])]
    public function index2(ManagerRegistry $doctrine, $slug):Response{
        //services symfony
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
        $new = $doctrine->getRepository(Etudiant::class)->find(intval($slug));
        $new->setPrenom($prenom);
        $new->setNom($nom);
        $new->setSection($repo->find($section));
        $manager->persist($new);
        $manager->flush();

        $this->addFlash("info", "le changemenet a ete effectué avec succes");
        return $this->redirectToRoute("app_list_all");

    }
}
