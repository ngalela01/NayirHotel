<?php

namespace App\Controller;

use App\Entity\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AcceuilController extends AbstractController
{
    #[Route('/', name: 'app_acceuil')]
    
    public function index(EntityManagerInterface $em): Response
    {   // Récupérer tous les services depuis la base de données
        $services = $em->getRepository(Service::class)->findAll();

        // Passer les services récupérés au template Twig pour l'affichage
        return $this->render('acceuil/index.html.twig', [
            'services' => $services,
            
        ]);
    }
}