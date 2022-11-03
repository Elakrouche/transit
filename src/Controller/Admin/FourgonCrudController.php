<?php

namespace App\Controller\Admin;

use App\Entity\Fourgon;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FourgonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Fourgon::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
