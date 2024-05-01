<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Images;
use App\Entity\Chambre;
use App\Entity\Service;
use App\Entity\TypeDeChambre;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        
        return $this->render('bundles/EasyAdminBundle/welcome.html.twig');
    }
    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('public/asset/css/style.css');
    }
    

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('NayirHotel');
    }

    public function configureMenuItems(): iterable
    {  yield MenuItem::linkToRoute('NayirHotel', 'fa fa-hotel', 'app_acceuil');
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
         yield MenuItem::linkToCrud('Utilisateur', 'fas fa-user', User::class)->setCssClass('.nayir');
         yield MenuItem::linkToCrud('Type de chambre', 'fas fa-list', TypeDeChambre::class);
         yield MenuItem::linkToCrud('Les chambres', 'fas fa-list', Chambre::class);
         yield MenuItem::linkToCrud('Sevices', 'fas fa-table-list', Service::class);
         yield MenuItem::linkToCrud('Images', 'fas fa-image', Images::class);
    }
    
}