<?php

namespace App\Controller;

use App\Form\ImagesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AcceuilController extends AbstractController
{
    #[Route('/', name: 'app_acceuil')]
    public function index(): Response
    { $form= $this->createForm(ImagesType::class);
        return $this->render('acceuil/index.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}