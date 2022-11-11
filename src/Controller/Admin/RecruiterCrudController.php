<?php

namespace App\Controller\Admin;

use App\Entity\Recruiter;
use App\Form\RoleType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

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
            ->setEntityPermission('ROLE_RECRUITER')
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermissions([
                Action::NEW => 'ROLE_ADMIN',
                Action::DELETE => 'ROLE_ADMIN',
                Action::EDIT => 'ROLE_RECRUITER',
                Action::INDEX => 'ROLE_RECRUITER',
                Action::DETAIL => 'ROLE_RECRUITER',
                Action::BATCH_DELETE => 'ROLE_ADMIN',
            ])
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('email')->setRequired(true)->setPermission('ROLE_RECRUITER'),
            Field::new('password','Mot de passe')->setPermission('ROLE_RECRUITER')
                ->hideWhenUpdating()->hideOnIndex()->hideOnDetail()
                ->setRequired(true)
                ->setFormType( RepeatedType::class )
                ->setFormTypeOptions( [
                    'type'            => PasswordType::class,
                    'first_options'   => [ 'label' => 'Mot de passe' ],
                    'second_options'  => [ 'label' => 'Vérification du mot de passe' ],
                    'error_bubbling'  => true,
                    'invalid_message' => 'Les mots de passe ne correspondent pas.',
                ])
            ,
            ChoiceField::new( 'roles', 'Role')->setPermission('ROLE_RECRUITER')
                ->setChoices([
                    'RECRUTEUR' => 'ROLE_RECRUITER',
                ])
                ->hideOnIndex()
                ->allowMultipleChoices(false)
                ->renderExpanded()
                ->setFormType(RoleType::class)
                ->setRequired(true)
            ,
            TextField::new('companyName', 'Nom de l\'entreprise')->setPermission('ROLE_RECRUITER'),
            TextField::new('address', 'Adresse de l\'entreprise')->setPermission('ROLE_RECRUITER'),
            BooleanField::new('isActive', 'Compte actif/inactif')->setPermission('ROLE_CONSULTANT'),
            AssociationField::new('JobOffers', 'Offres d\'emploi')->hideWhenCreating()->hideWhenUpdating()->setPermission('ROLE_RECRUITER'),
        ];
    }

}
