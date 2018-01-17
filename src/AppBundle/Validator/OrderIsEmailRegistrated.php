<?php


namespace AppBundle\Validator;


use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class OrderIsEmailRegistrated extends Constraint
{

    public $message = 'An account with this email address exists';

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

}