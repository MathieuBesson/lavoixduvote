<?php

namespace App\Controller\Admin;

use App\Entity\Glossary;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GlossaryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Glossary::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('word', 'Word'),
            TextEditorField::new('definition', 'Definition'),
            TextField::new('source', 'Source'),
            AssociationField::new('category', 'Category')
        ];
    }
}
