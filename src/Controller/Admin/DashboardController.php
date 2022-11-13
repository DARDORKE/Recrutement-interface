<?php

namespace App\Controller\Admin;

use App\Entity\Candidate;
use App\Entity\JobOffer;
use App\Entity\Recruiter;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_CONSULTANT');

        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(JobOfferCrudController::class)->generateUrl();
        return $this->redirect($url);


        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle(
                '<img src="img/brand.png" alt="logo" width="250">'
            )
            ->setFaviconPath('img/brand.png');

    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Comptes utilisateurs', 'fa-solid fa-users', User::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Comptes candidat', 'fa-solid fa-user-graduate', Candidate::class)->setPermission('ROLE_CONSULTANT');
        yield MenuItem::linkToCrud('Comptes recruteur', 'fa-solid fa-user-tie', Recruiter::class)->setPermission('ROLE_CONSULTANT');
        yield MenuItem::linkToCrud('Offres d\'emploi', 'fa-solid fa-briefcase', JobOffer::class)->setPermission('ROLE_CONSULTANT');
    }
}
