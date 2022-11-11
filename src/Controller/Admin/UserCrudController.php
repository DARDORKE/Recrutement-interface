<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\RoleType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

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
            ->setEntityPermission('ROLE_ADMIN')
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermissions([
                Action::NEW => 'ROLE_ADMIN',
                Action::DELETE => 'ROLE_ADMIN',
                Action::EDIT => 'ROLE_ADMIN',
                Action::INDEX => 'ROLE_ADMIN',
                Action::DETAIL => 'ROLE_ADMIN',
                Action::BATCH_DELETE => 'ROLE_ADMIN',
            ])
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('email', 'Adresse Email')->setRequired(true)->setPermission('ROLE_ADMIN'),
            Field::new('password','Mot de passe')->setRequired(true)->setPermission('ROLE_ADMIN')
                ->hideWhenUpdating()->hideOnIndex()->hideOnDetail()
                ->setFormType( RepeatedType::class )
                ->setFormTypeOptions( [
                    'type'            => PasswordType::class,
                    'first_options'   => [ 'label' => 'Mot de passe' ],
                    'second_options'  => [ 'label' => 'Vérification du mot de passe' ],
                    'error_bubbling'  => true,
                    'invalid_message' => 'Les mots de passe ne correspondent pas.',
                ]),
            ChoiceField::new( 'roles', 'Role')->setPermission('ROLE_ADMIN')
                ->setChoices([
                    'ADMINISTRATEUR' => 'ROLE_ADMIN',
                    'CONSULTANT' => 'ROLE_CONSULTANT',
                ])
                ->allowMultipleChoices(false)
                ->renderExpanded()
                ->setFormType(RoleType::class)
                ->setRequired(true)
            ,
        ];
    }

}
