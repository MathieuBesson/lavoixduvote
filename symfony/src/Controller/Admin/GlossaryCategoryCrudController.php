<?php

namespace App\Controller\Admin;

use App\Entity\GlossaryCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GlossaryCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GlossaryCategory::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('Label'),
        ];
    }
}
