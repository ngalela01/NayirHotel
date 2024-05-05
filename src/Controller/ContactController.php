<?php

namespace App\Controller;

use App\Form\ContactType;
use SessionIdInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request,MailerInterface $mailer ): Response
    {   $form=$this->createForm(ContactType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $data=$form->getData();
            $email = (new Email())
            ->from($data['email'])
            ->to('admin@test.fr')
            ->subject($data['sujet'])
            ->text($data['message']);

        $mailer->send($email);
        
        // ajouter un message   
        $this->addFlash('success', 'Votre message a bien été envoyé');

        // Vider les champs du formulaire
        $form = $this->createForm(ContactType::class);
        
        }
        return $this->render('contact/index.html.twig', [
            'form'=>$form->createView()
        ]);
        
    }
    

}