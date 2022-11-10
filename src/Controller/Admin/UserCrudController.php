<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Compte utilisateur')
            ->setEntityLabelInPlural('Compte utilisateur')
            ->setPageTitle('index', 'Tous les comptes utilisateur')
            ->setPageTitle('new', 'Création d\'un nouveau compte utilisateur')
            ->setPageTitle('detail', fn (User $user) => sprintf('<b>%s</b>', $user->getEmail()))
            ->setPageTitle('edit', fn (User $user) => sprintf('Modification de <b>%s</b>', $user->getEmail()))
            ->setAutofocusSearch()
            ;
    }


    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
