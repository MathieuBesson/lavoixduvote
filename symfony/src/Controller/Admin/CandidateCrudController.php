<?php

namespace App\Controller\Admin;

use App\Entity\Candidate;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CandidateCrudController extends AbstractCrudController {

    public static function getEntityFqcn(): string {
        return Candidate::class;
    }


    public function configureFields(string $pageName): iterable {
        return [
            AssociationField::new('politicalParty', 'Parti Politique'),
            TextField::new('lastName', 'Nom'),
            TextField::new('firstName', 'Prénom'),
            ImageField::new('picture', 'Photo')
                      ->setBasePath('uploads/candidates')
                      ->setUploadDir('public/uploads/candidates')
                      ->setUploadedFileNamePattern('[randomhash].[extension]')
                      ->setRequired(FALSE),
            TextEditorField::new('biography', 'Biographie'),
            BooleanField::new('electedByPrimary', 'Élu aux primaires'),
            BooleanField::new('secondRoundElections', 'Présent au deuxième tour des élections'),
        ];
    }

}
