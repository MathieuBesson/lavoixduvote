<?php

namespace App\Controller\Admin;

use App\Entity\Action;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ActionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Action::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('theme', 'Theme'),
            TextField::new('title', 'Action'),
        ];
    }
}
