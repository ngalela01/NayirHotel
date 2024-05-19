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
        $search = new SearchData();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();
            $chambres = $chambreRepository->findWithSearch($search);
            return $this->redirectToRoute('app_chambre_index', [
                'dateArrivee' => $search->getDateArrivee()? $search->getDateArrivee()->format('Y-m-d') : null,
                'dateDepart' => $search->getDateDepart()? $search->getDateDepart()->format('Y-m-d') : null,
                'capaciteAdulte' => $search->getCapaciteAdulte(),
                'capaciteEnfant' => $search->getCapaciteEnfant(),
            ]);
        }

        // Vérifiez si les paramètres de recherche sont présents dans l'URL
        if ($request->query->has('dateArrivee') || $request->query->has('dateDepart') || $request->query->has('capaciteAdulte') || $request->query->has('capaciteEnfant')) {
            $search->setDateArrivee($request->query->get('dateArrivee')? new \DateTime($request->query->get('dateArrivee')) : null);
            $search->setDateDepart($request->query->get('dateDepart')? new \DateTime($request->query->get('dateDepart')) : null);
            $search->setCapaciteAdulte($request->query->get('capaciteAdulte')!== null? (int)$request->query->get('capaciteAdulte') : null);
            $search->setCapaciteEnfant($request->query->get('capaciteEnfant')!== null? (int)$request->query->get('capaciteEnfant') : null);
            $chambres = $chambreRepository->findWithSearch($search);
        } else {
            $chambres = $chambreRepository->findAll();
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