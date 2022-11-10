<?php

namespace App\Controller\Admin;

use App\Entity\Candidate;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CandidateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Candidate::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Candidat')
            ->setEntityLabelInPlural('Candidats')
            ->setPageTitle('index', 'Toutes les candidats')
            ->setPageTitle('new', 'Création d\'un nouveau candidat')
            ->setPageTitle('detail', fn (Candidate $candidate) => sprintf('<b>%s</b>', $candidate->getEmail()))
            ->setPageTitle('edit', fn (Candidate $candidate) => sprintf('Modification de <b>%s</b>', $candidate->getEmail()))
            ->setAutofocusSearch()
            ;
    }
}
