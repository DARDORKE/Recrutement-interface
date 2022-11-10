<?php

namespace App\Controller\Admin;

use App\Entity\JobOffer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('jobTitle', 'Intitulé du poste')->setRequired(true),
            TextField::new('workplace','Lieu de travail')->setRequired(true),
            TextareaField::new('description', 'Description du poste')->setRequired(true),
            BooleanField::new('isPublished', 'Active/Inactive'),
            AssociationField::new('recruiter', 'Recruteur')->hideWhenCreating()->hideWhenUpdating(),
            AssociationField::new('candidates', 'Liste des candidats')->hideWhenCreating()->hideWhenUpdating(),
        ];
    }
}
