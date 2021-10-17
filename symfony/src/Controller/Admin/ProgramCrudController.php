<?php

namespace App\Controller\Admin;

use App\Entity\Program;
use App\Form\ActionType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Symfony\Component\Form\Extension\Core\Type\FormType;

class ProgramCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Program::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('candidate', 'Candidate')->setCssClass('candidate-wrapper'),
            TextEditorField::new('presentation', 'Presentation'),
            UrlField::new('programLink', 'Program link'),
            CollectionField::new('actions', 'Actions')
                ->setSortable(true)
                ->allowAdd()
                ->allowDelete()
                ->setEntryIsComplex(true)
                ->setEntryType(ActionType::class)
                ->setFormTypeOptions([
                    'by_reference' => 'true'
                ])
                ->setCssClass('actions-wrapper')
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud
            ->overrideTemplate('crud/new', 'admin/program/new.html.twig')
            ->overrideTemplate('crud/edit', 'admin/program/edit.html.twig');
        return $crud;
    }
}
