<?php

namespace App\Controller\Admin;

use App\Entity\StarMeasure;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StarMeasureCrudController extends AbstractCrudController {

    public static function getEntityFqcn(): string {
        return StarMeasure::class;
    }


    public function configureFields(string $pageName): iterable {
        return [
            AssociationField::new('candidate', 'Candidat'),
            TextField::new('icon', 'Icon class'),
            TextField::new('title', 'Title'),
            TextEditorField::new('description', 'Description'),
        ];
    }

}
