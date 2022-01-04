<?php

namespace App\Controller\Admin;

use App\Entity\Faq;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FaqCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Faq::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextEditorField::new('title', 'Title'),
            TextEditorField::new('content', 'Content'),
            TextField::new('source', 'Source'),
            AssociationField::new('theme', 'Theme'),
            TextField::new('icon', 'Icon'),
            BooleanField::new('faq', 'Part of FAQ')
        ];
    }
}
