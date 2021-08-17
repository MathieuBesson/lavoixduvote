<?php

namespace App\Controller\Admin;

use App\Entity\Primary;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class PrimaryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Primary::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('politicalParty', 'Political party'),
            AssociationField::new('candidates', 'Candidates')
                ->setFormTypeOptions([
                        'by_reference' => false,
                    ]
                ),
            DateField::new('dateFirstRound', 'Date of the first round'),
            DateField::new('dateSecondRound', 'Date of the second round'),
        ];
    }
}
