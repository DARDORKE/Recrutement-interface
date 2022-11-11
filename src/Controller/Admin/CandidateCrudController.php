<?php

namespace App\Controller\Admin;

use App\Entity\Candidate;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

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
            ->setPageTitle('index', 'Tous les candidats')
            ->setPageTitle('new', 'Création d\'un nouveau candidat')
            ->setPageTitle('detail', fn (Candidate $candidate) => sprintf('<b>%s</b>', $candidate->getEmail()))
            ->setPageTitle('edit', fn (Candidate $candidate) => sprintf('Modification de <b>%s</b>', $candidate->getEmail()))
            ->setAutofocusSearch()
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermissions([
                Action::NEW => 'ROLE_ADMIN',
                Action::DELETE => 'ROLE_ADMIN',
                Action::EDIT => 'ROLE_CANDIDATE',
                Action::INDEX => 'ROLE_CANDIDATE',
                Action::DETAIL => 'ROLE_CANDIDATE',
                Action::BATCH_DELETE => 'ROLE_ADMIN',
            ])
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('email')->setRequired(true),
            Field::new('password','Mot de passe')->setRequired(true)
                ->hideWhenUpdating()
                ->setFormType( RepeatedType::class )
                ->setFormTypeOptions( [
                    'type'            => PasswordType::class,
                    'first_options'   => [ 'label' => 'Mot de passe' ],
                    'second_options'  => [ 'label' => 'Vérification du mot de passe' ],
                    'error_bubbling'  => true,
                    'invalid_message' => 'Les mots de passe ne correspondent pas.',
                ]),
            ChoiceField::new( 'roles', 'Role')
                ->setChoices([
                    'CANDIDAT' => 'ROLE_CANDIDATE',
                ])
                ->allowMultipleChoices(false)
                ->renderExpanded()
                ->setFormType(RoleType::class)
                ->setRequired(true)
            ,
            TextField::new('firstName', 'Prénom'),
            TextField::new('lastName', 'Nom'),
            ImageField::new('cv', 'Votre CV')
                ->setFormType(FileUploadType::class)
                ->setBasePath('candidate_cvs/')
                ->setUploadDir('public/candidate_cvs/')
                ->setColumns(6)
                ->hideOnIndex()
                ->setFormTypeOptions(['attr' => [
                        'accept' => 'application/pdf']]),
            TextField::new('cv', 'CV')->setTemplatePath('admin/fields/document_link.html.twig')->onlyOnIndex(),
            BooleanField::new('isActive', 'Compte actif/inactif'),
            AssociationField::new('JobOffers', 'Offres d\'emploi')->hideWhenCreating()
        ];
    }
}
