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
            AssociationField::new('politicalParty', 'Political party'),
            TextField::new('lastName', 'Last name'),
            TextField::new('firstName', 'First name'),
            TextField::new('pictureSource', 'Picture source'),
            ImageField::new('picture', 'Picture')
                      ->setBasePath('uploads/candidates')
                      ->setUploadDir('public/uploads/candidates')
                      ->setUploadedFileNamePattern('[randomhash].[extension]')
                      ->setRequired(FALSE),
            TextEditorField::new('biography', 'Biography'),
            BooleanField::new('electedByPrimary', 'Elected by primary'),
            BooleanField::new('secondRoundElections', 'Present at the second round of election'),
        ];
    }

}
