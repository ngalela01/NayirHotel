<?php

namespace App\Controller;

use App\Form\SearchData;
use App\Form\SearchType;
use App\Repository\ChambreRepository;
use App\Repository\ServiceRepository;
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
        // Récupérer tous les chambres depuis la base de données
        $chambres= $chambreRepo->findAll();
        
        //Calcul de la note moyenne de chaque chambre
        foreach ($chambres as &$chambre) {
            $averageRating = $chambreRepo->findAverageRatingByChambreId($chambre->getId());
            $chambre->setNoteMoyenne($averageRating);
        }
        
        

        // Gestion du formulaire de recherche
        $search= new SearchData() ; 
        $form=$this->createForm(SearchType::class, $search);
        
        $form->handleRequest($request); // On récupère les données du formulaire

        
        
        if ($form->isSubmitted() && $form->isValid()) // On vérifie si le formulaire est soumis et valide
        {
            // Utiliser les critères de recherche pour récupérer les chambres filtrées
            $searchData = $form->getData();
            
            return $this->redirectToRoute('app_chambre_index', [
                'dateArrivee' => $searchData->getDateArrivee(),
                'dateDepart' => $searchData->getDateDepart(), 
                'capaciteAdulte' => $searchData->getCapaciteAdulte(),
                'capaciteEnfant' => $searchData->getCapaciteEnfant(),
            ]);
        }

        // Passer les services récupérés au template Twig pour l'affichage
        return $this->render('acceuil/index.html.twig', [
            'services' => $services,
            'chambres' => $chambres,
            'form' => $form->createView(),
            
        ]);
    }
}