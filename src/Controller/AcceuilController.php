<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Entity\Service;
use App\Form\SearchType;
use App\Repository\ChambreRepository;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AcceuilController extends AbstractController
{
    #[Route('/', name: 'app_acceuil')]
    
    public function index(ChambreRepository $chambreRepo, ServiceRepository $serviceRepo,Request $request): Response
    {   // Récupérer tous les services depuis la base de données
        $services = $serviceRepo->findAll();
        $chambres= $chambreRepo->findAll();

        
        $form=$this->createForm(SearchType::class);
        $form->handleRequest($request); // On récupère les données du formulaire
        if($form->isSubmitted() && $form->isValid()) // On vérifie si le formulaire est soumis et valide
        {   // On récupère les données du formulaire
        }

        

        // Passer les services récupérés au template Twig pour l'affichage
        return $this->render('acceuil/index.html.twig', [
            'services' => $services,
            'chambres' => $chambres,
            'form' => $form->createView(),
            
        ]);
    }
}