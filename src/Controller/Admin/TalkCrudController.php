<?php

namespace App\Controller\Admin;

use App\Entity\Talk;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Survos\EzBundle\Controller\BaseCrudController;

class TalkCrudController extends BaseCrudController
{
    public static function getEntityFqcn(): string
    {
        return Talk::class;
    }

    public function configureFields(string $pageName): iterable
    {

        yield IdField::new('id')->hideOnForm();

        /** @var Field $field */
        foreach (parent::configureFields($pageName) as $field) {
            $propertyName = $field->getAsDto()->getPropertyNameWithSuffix();
            $easyadminField = match ($propertyName) {
                'marking' => ChoiceField::new('marking')->setChoices(
                    $this->workflow->getDefinition()->getPlaces()
                ),
                'id' => null,
                'fetchStatusCode' => $field->setLabel('Fetch Status'),
                'downloadStatusCode' => $field->setLabel('Download Status'),

                default => $field,
            };
            if ($easyadminField) {
                yield $easyadminField;
            }
        }
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
