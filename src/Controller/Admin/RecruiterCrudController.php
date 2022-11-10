<?php

namespace App\Controller\Admin;

use App\Entity\Recruiter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RecruiterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recruiter::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Compte recruteur')
            ->setEntityLabelInPlural('Compte recruteur')
            ->setPageTitle('index', 'Tous les comptes recruteur')
            ->setPageTitle('new', 'Création d\'un nouveau compte recruteur')
            ->setPageTitle('detail', fn (Recruiter $recruiter) => sprintf('<b>%s</b>', $recruiter->getEmail()))
            ->setPageTitle('edit', fn (Recruiter $recruiter) => sprintf('Modification de <b>%s</b>', $recruiter->getEmail()))
            ->setAutofocusSearch()
            ;
    }

}
