<?php

namespace App\Controller\Admin;

use App\Entity\Program;
use App\Form\ActionType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class ProgramCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Program::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('candidate', 'Candidate'),
            TextEditorField::new('presentation', 'Presentation'),
            UrlField::new('programLink', 'Program link'),
            CollectionField::new('actions', 'Actions')
	            ->setSortable(true)
		        ->allowAdd()
		        ->allowDelete()
		        ->setEntryIsComplex(true)
		        ->setEntryType(ActionType::class)
		        ->setFormTypeOptions([
					'by_reference' => 'false'
	        ])->setSortable(true)
        ];
    }
}
