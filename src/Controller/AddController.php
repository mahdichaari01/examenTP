<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Section;
use App\Form\AddEtudiantType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddController extends AbstractController
{
    #[Route('/add', name: 'app_add')]
    public function index(ManagerRegistry $doctrine,Request $request): Response
    {
        $manager=$doctrine->getManager();

        $new = new Etudiant();
        $new->setNom("nom")->setPrenom("prenom")->setSection(null);

        $form = $this->createForm(AddEtudiantType::class, $new);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $new = $form->getData();
            $manager->persist($new);
            $manager->flush();
            // ... perform some action, such as saving the task to the database
            $this->addFlash("info", "insertion with success");
            return $this->redirectToRoute('app_list_all');
        }


        return $this->renderForm('add/index.html.twig', [
            'form' => $form,
        ]);

    }
}
