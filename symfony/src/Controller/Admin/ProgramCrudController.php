<?php

namespace App\Controller\Admin;

use App\Entity\Program;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
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
            AssociationField::new('candidate', 'Candidat'),
            TextEditorField::new('presentation', 'Présentation'),
            UrlField::new('programLink', 'Lien vers le programme'),
            AssociationField::new('actions', 'Actions'),
        ];
    }
}
