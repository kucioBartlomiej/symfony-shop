<?php


namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ProductName extends Constraint
{
    public $message = 'Product with this name exist!';

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}