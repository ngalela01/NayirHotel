<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Entity\Reservations;
use App\Form\ReservationsType;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/reservations')]
class ReservationsController extends AbstractController
{
    

    
    // methode pour resrver une chambre spécifique
    #[Route('/chambres/{id}', name: 'app_chambres_reserver', methods: ['GET', 'POST'])]
    public function reserver(Request $request, Chambre $chambre, EntityManagerInterface $entityManager , Security $security , MailerInterface $mailer): Response
    {
        $reservation = new Reservations();
        $reservation->setChambre($chambre);
        $form = $this->createForm(ReservationsType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $security->getUser(); // Récupérer l'utilisateur actuellement connecté
            if ($user) {
                $reservation->setUser($user); // Associer l'utilisateur à la réservation
            } else {
                throw new \Exception("Utilisateur non trouver");
            }
            $reservation->setCreatedAt(new \DateTimeImmutable());
            $reservation->setConfirmation(false); // Par défaut à false pour les utilisateurs
            $entityManager->persist($reservation);
            $entityManager->flush();
            
            // Ajouter un message flash pour alerter l'utilisateur
            $this->addFlash('success', 'Votre réservation a été effectuée avec succès. Vous recevrez un email de confirmation sous peu.');
            
            // Envoyer un email à l'administrateur
            $email = (new Email())
                ->from($reservation->getEmail())
                ->to('admin@test.fr')
                ->subject('Nouvelle réservation effectuée')
                ->html('<p>Une nouvelle réservation a été effectuée. Veuillez la confirmer dans le système de gestion des réservations.</p>');

            $mailer->send($email);
            // return $this->redirectToRoute('app_reservations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservations/reservation.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }


   

    
}