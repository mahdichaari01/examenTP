<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Section;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    #[Route('/delete/{slug}', name: 'app_delete')]
    public function index(ManagerRegistry $doctrine,$slug): Response
    {
        $old = $doctrine->getRepository(Etudiant::class)->find(intval($slug));
        $doctrine->getManager()->remove($old);
        $doctrine->getManager()->flush();
        $this->addFlash("info","item deleted with success");
        return $this->redirectToRoute("app_list_all");
    }
}
