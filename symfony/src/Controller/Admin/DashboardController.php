<?php

namespace App\Controller\Admin;

use App\Entity\Action;
use App\Entity\Candidate;
use App\Entity\Glossary;
use App\Entity\PoliticalParty;
use App\Entity\Primary;
use App\Entity\Program;
use App\Entity\Theme;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController {

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect(
            $routeBuilder->setController(PoliticalPartyCrudController::class)
                         ->generateUrl()
        );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('La Voix du Vote')
            ->setTranslationDomain('admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Political party', 'fas fa-landmark', PoliticalParty::class);
        yield MenuItem::linkToCrud('Candidates', 'fas fa-user-tie', Candidate::class);
        yield MenuItem::linkToCrud('Primary', 'fas fa-poll', Primary::class);
        yield MenuItem::linkToCrud('Programs', 'fas fa-scroll', Program::class);
        yield MenuItem::linkToCrud('Themes', 'fas fa-project-diagram', Theme::class);
        yield MenuItem::linkToCrud('Actions', 'fas fa-balance-scale-left', Action::class);
        yield MenuItem::linkToCrud('Glossary', 'fas fa-spell-check', Glossary::class);
    }
}
