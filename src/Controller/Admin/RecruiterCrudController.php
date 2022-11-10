<?php

namespace App\Controller\Admin;

use App\Entity\Recruiter;
use App\Form\RoleType;
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
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('email')->setRequired(true),
            Field::new('password','Mot de passe')
                ->hideWhenUpdating()
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
            ChoiceField::new( 'roles', 'Role')
                ->setChoices([
                    'RECRUTEUR' => 'ROLE_RECRUITER',
                ])
                ->hideOnIndex()
                ->allowMultipleChoices(false)
                ->renderExpanded()
                ->setFormType(RoleType::class)
                ->setRequired(true)
            ,
            TextField::new('companyName', 'Nom de l\'entreprise'),
            TextField::new('address', 'Adresse de l\'entreprise'),
            BooleanField::new('isActive', 'Compte actif/inactif')

            ,
            AssociationField::new('JobOffers', 'Offres d\'emploi')->hideWhenUpdating()
        ];
    }

}
