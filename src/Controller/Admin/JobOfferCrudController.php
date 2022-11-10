<?php

namespace App\Controller\Admin;

use App\Entity\JobOffer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class JobOfferCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return JobOffer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Offre d\'emploi')
            ->setEntityLabelInPlural('Offres d\'emploi')
            ->setPageTitle('index', 'Toutes les offres d\'emploi')
            ->setPageTitle('new', 'Création d\'une nouvelle offre d\'emploi')
            ->setPageTitle('detail', fn (JobOffer $jobOffer) => sprintf('<b>%s</b>', $jobOffer->getJobTitle()))
            ->setPageTitle('edit', fn (JobOffer $jobOffer) => sprintf('Modification de <b>%s</b>', $jobOffer->getJobTitle()))
            ->setAutofocusSearch()
            ;
    }
}
