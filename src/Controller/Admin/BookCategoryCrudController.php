<?php

namespace App\Controller\Admin;

use App\Entity\BookCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class BookCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BookCategory::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom de la catégorie'),
            AssociationField::new('books', 'Livres liés')->setFormTypeOption('by_reference', false),
        ];
    }
}
