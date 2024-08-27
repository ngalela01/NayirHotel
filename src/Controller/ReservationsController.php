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
    // Méthode pour vérifier la disponibilité des dates
    private function areDatesAvailable(Chambre $chambre, \DateTimeInterface $dateArrivee, \DateTimeInterface $dateDepart, EntityManagerInterface $entityManager): bool
    {
        $reservations = $entityManager->getRepository(Reservations::class)->findBy(['chambre' => $chambre]);
        
        foreach ($reservations as $reservation) {
            if (
                ($dateArrivee >= $reservation->getDateArrive() && $dateArrivee < $reservation->getDateDepart()) ||
                ($dateDepart > $reservation->getDateArrive() && $dateDepart <= $reservation->getDateDepart()) ||
                ($dateArrivee < $reservation->getDateArrive() && $dateDepart > $reservation->getDateDepart())
            ) {
                return false;
            }
        }
        
        return true;
    }

    
    // methode pour resrver une chambre spécifique
    #[Route('/chambres/{id}', name: 'app_chambres_reserver', methods: ['GET', 'POST'])]
    public function reserver(Request $request, Chambre $chambre, EntityManagerInterface $entityManager , Security $security , MailerInterface $mailer): Response
    {   
        $user = $security->getUser(); // Récupérer l'utilisateur actuellement connecté
        if (!$user) {
            $this->addFlash('warning', 'Vous devez être connecté pour effectuer une réservation.');
            return $this->redirectToRoute('app_login'); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
        }
        
        $reservation = new Reservations();
        $reservation->setChambre($chambre);
        $form = $this->createForm(ReservationsType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $reservation->setUser($user); // Associer l'utilisateur à la réservation
            $reservation->setCreatedAt(new \DateTimeImmutable());
            $reservation->setConfirmation(false); // Par défaut à false pour les utilisateurs
            
            // Vérifiez la disponibilité des dates
            if ($this->areDatesAvailable($chambre, $reservation->getDateArrive(), $reservation->getDateDepart(), $entityManager)) {
                try{
                    $entityManager->persist($reservation);
                    $entityManager->flush();
                
                    // Ajouter un message flash pour alerter l'utilisateur
                    $this->addFlash('success', 'Votre réservation a été effectuée avec succès. Vous recevrez un email de confirmation sous peu.');
                    
                    // Envoyer un email à l'administrateur
                    $email = (new Email())
                        ->from($reservation->getEmail())
                        ->to('admin@test.fr')
                        ->subject('Nouvelle réservation effectuée')
                        ->html('<p>Une nouvelle réservation a été effectuée. Veuillez la confirmer dans le système de gestion des réservations.</p>
                                <p><strong>Demande spéciale:</strong> ' . $reservation->getDemandeSpeciale() . '</p>');

                    $mailer->send($email);
                } catch (\Exception $e){ // Code pour gérer l'exception
                $this->addFlash('error', 'Une erreur est survenue lors de la réservation.');}
                
            }else{
                // Ajouter un message flash pour alerter l'utilisateur que les dates ne sont pas disponibles
                $this->addFlash('warning', 'Les dates sélectionnées ne sont pas disponibles.');
            }
        
        }
        return $this->render('reservations/reservation.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
            'chambre' => $chambre, 
        ]);
        
    }
        

    
    //Methode pour voir les reservations
    #[Route('/mes-reservations', name: 'app_reservations_mes_reservations', methods: ['GET'])]
    public function mesReservations(EntityManagerInterface $entityManager, Security $security): Response
    {   
        $user = $security->getUser();

        if (!$user) {
        throw $this->createAccessDeniedException('Vous devez être connecté pour voir vos réservations.');
        }
        
        $reservations = $entityManager->getRepository(Reservations::class)->findBy(['user' => $user]);

        return $this->render('reservations/mes_reservations.html.twig', [
            'reservations' => $reservations,
        ]);
    }
   

    
}