<?php

namespace App\Controller\Admin;

use App\Entity\JobOffer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
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
            ->setEntityPermission('ROLE_USER')
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermissions([
                Action::NEW => 'ROLE_RECRUITER',
                Action::DELETE => 'ROLE_RECRUITER',
                Action::EDIT => 'ROLE_RECRUITER',
                Action::INDEX => 'ROLE_USER',
                Action::DETAIL => 'ROLE_USER',
                Action::BATCH_DELETE => 'ROLE_RECRUITER',
            ])
            ;
    }

    public function configureFields(string $pageName): iterable
    {

            yield TextField::new('jobTitle', 'Intitulé du poste')->setRequired(true)->setPermission('ROLE_USER');
            yield TextField::new('workplace','Lieu de travail')->setRequired(true)->setPermission('ROLE_USER');
            yield TextareaField::new('description', 'Description du poste')->setRequired(true)->setPermission('ROLE_USER');
            yield BooleanField::new('isPublished', 'Active/Inactive')->setPermission('ROLE_CONSULTANT');
            yield AssociationField::new('recruiter', 'Recruteur')->hideWhenUpdating()->setRequired(true)->setPermission('ROLE_USER');
            yield AssociationField::new('candidates', 'Liste des candidats')->hideWhenCreating()->hideWhenUpdating()->setPermission('ROLE_RECRUITER');

    }
}
