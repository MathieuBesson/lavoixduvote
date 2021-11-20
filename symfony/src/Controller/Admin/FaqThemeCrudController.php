<?php

namespace App\Controller\Admin;

use App\Entity\FaqTheme;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FaqThemeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FaqTheme::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('label', 'Label'),
        ];
    }
}
