<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Entity\Reservations;
use App\Form\ReservationsType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/reservations')]
class ReservationsController extends AbstractController
{
    

    
    // methode pour resrver une chambre spécifique
    #[Route('/chambres/{id}', name: 'app_chambres_reserver', methods: ['GET', 'POST'])]
    public function reserver(Request $request, Chambre $chambre, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservations();
        $reservation->setChambre($chambre);
        $form = $this->createForm(ReservationsType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservations/reservation.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }


   

    
}