<?php

namespace App\Controller\Admin;

use App\Entity\PoliticalParty;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PoliticalPartyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PoliticalParty::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Name'),
            TextEditorField::new('description', 'Description'),
            ImageField::new('picture', 'Picture')
                      ->setBasePath('uploads/politicalParties')
                      ->setUploadDir('public/uploads/politicalParties')
                      ->setUploadedFileNamePattern('[randomhash].[extension]')
                      ->setRequired(FALSE),
            UrlField::new('siteLink', 'Party website')
        ];
    }

}
