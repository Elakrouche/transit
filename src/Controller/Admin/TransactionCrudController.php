<?php

namespace App\Controller\Admin;

use App\Entity\Transaction;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use phpDocumentor\Reflection\Types\Integer;

class TransactionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Transaction::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            DateField::new('Date_transit'),
            IntegerField::new('Montant'),
            TextField::new('Num_facture'),
            TextField::new('Num_dossier'),
            AssociationField::new('Agent_matricule'),
            AssociationField::new('Fournisseur_matri'),
            AssociationField::new('Client'),
            AssociationField::new('fourgon'),
            AssociationField::new('Remorque'),
            AssociationField::new('Parking_matricule'),

        ];
    }
}
