<?php

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CategoryName extends Constraint
{
    public $message = 'This category exist!';

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}