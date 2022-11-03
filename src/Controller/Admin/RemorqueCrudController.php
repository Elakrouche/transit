<?php

namespace App\Controller\Admin;

use App\Entity\Remorque;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RemorqueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Remorque::class;
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
