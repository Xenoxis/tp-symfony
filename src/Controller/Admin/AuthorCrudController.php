<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class AuthorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Author::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('name'),
            TextEditorField::new('biography'),
        ];

        // Affiche le champ "books" uniquement sur la page de détail
        if ($pageName === Crud::PAGE_DETAIL) {
            $fields[] = AssociationField::new('books')
                ->setTemplatePath('admin/fields/books_list.html.twig'); // Optionnel si tu as un template personnalisé
        }

        return $fields;
    }
}
