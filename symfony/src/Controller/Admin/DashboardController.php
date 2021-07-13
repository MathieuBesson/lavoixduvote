<?php

namespace App\Controller\Admin;

use App\Entity\Action;
use App\Entity\Candidate;
use App\Entity\Glossary;
use App\Entity\PoliticalParty;
use App\Entity\Program;
use App\Entity\Theme;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('La Voix du Vote');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Partis Politiques', 'fas fa-landmark', PoliticalParty::class);
        yield MenuItem::linkToCrud('Candidats', 'fas fa-user-tie', Candidate::class);
        yield MenuItem::linkToCrud('Programmes', 'fas fa-scroll', Program::class);
        yield MenuItem::linkToCrud('Thèmes', 'fas fa-project-diagram', Theme::class);
        yield MenuItem::linkToCrud('Actions', 'fas fa-balance-scale-left', Action::class);
        yield MenuItem::linkToCrud('Glossaire', 'fas fa-spell-check', Glossary::class);
    }
}
