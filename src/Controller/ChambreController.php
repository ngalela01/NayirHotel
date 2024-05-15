<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Form\SearchData;
use App\Form\SearchType;
use App\Repository\ChambreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/chambre')]
class ChambreController extends AbstractController
{
    #[Route('/', name: 'app_chambre_index', methods: ['GET','POST'])]
    public function index(ChambreRepository $chambreRepository, Request $request): Response
    {  
         $chambres=$chambreRepository->findAll();
        
        
        $searchData = new SearchData();
        
        // Créez le formulaire et associez-le à une instance de votre entité
        $form=$this->createForm(SearchType::class,$searchData);

        // Traitez la requête
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, récupérez les données
        if ($form->isSubmitted() && $form->isValid()) {

            $searchData = $form->getData();
            $chambres=$chambreRepository->findWithSearch($searchData);            
            
        }

        
        return $this->render('chambre/index.html.twig', [
            'form' => $form->createView(),
            'chambres' => $chambres,
            
        ]);
    }

    

    
    #[Route('/{id}', name: 'app_chambre_show', methods: ['GET'])]
    public function show(Chambre $chambre): Response
    {
        return $this->render('chambre/show.html.twig', [
            'chambre' => $chambre,
        ]);
    }

    

    
}