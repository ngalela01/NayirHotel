<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConfidentialiteController extends AbstractController
{
    #[Route('/confidentialite', name: 'app_confidentialite')]
    public function index(): Response
    {
        return $this->render('confidentialite/index.html.twig', [
            
        ]);
    }
}