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
        // Création d'une nouvelle instance de SearchData pour stocker les critères de recherche
    $search = new SearchData();
    
    // Création du formulaire de recherche avec SearchType et l'instance de SearchData
    $form = $this->createForm(SearchType::class, $search);

    // Gestion automatique de la soumission du formulaire
    $form->handleRequest($request);

    // Vérification si le formulaire a été soumis et est valide
    if ($form->isSubmitted() && $form->isValid()) {
        // Récupération des données validées du formulaire
        $search = $form->getData();
        
        // Utilisation de la méthode findWithSearch du repository pour filtrer les chambres
        // en fonction des critères de recherche
        $chambres = $chambreRepository->findWithSearch($search);
        
        // Redirection vers la même page avec les critères de recherche ajoutés à l'URL
        return $this->redirectToRoute('app_chambre_index', [
            'dateArrivee' => $search->getDateArrivee(),
            'dateDepart' => $search->getDateDepart(),
            'capaciteAdulte' => $search->getCapaciteAdulte(),
            'capaciteEnfant' => $search->getCapaciteEnfant(),
        ]);
    }

    // Vérification si des critères de recherche sont présents dans l'URL
    if ($request->query->has('dateArrivee') || $request->query->has('dateDepart') || $request->query->has('capaciteAdulte') || $request->query->has('capaciteEnfant')) {
        // Mise à jour des critères de recherche avec les valeurs provenant de l'URL
        $search->setDateArrivee($request->query->get('dateArrivee'));
        $search->setDateDepart($request->query->get('dateDepart'));
        $search->setCapaciteAdulte($request->query->get('capaciteAdulte'));
        $search->setCapaciteEnfant($request->query->get('capaciteEnfant'));
        
        // Utilisation de la méthode findWithSearch du repository pour filtrer les chambres
        // en fonction des critères de recherche provenant de l'URL
        $chambres = $chambreRepository->findWithSearch($search);
    } else {
        // Si aucun critère de recherche n'est trouvé dans l'URL, récupération de toutes les chambres
        $chambres = $chambreRepository->findAll();
    }

    // Rendu du template Twig avec le formulaire et les chambres (filtrées ou non)
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