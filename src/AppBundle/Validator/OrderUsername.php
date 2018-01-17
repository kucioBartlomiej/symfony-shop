<?php


namespace AppBundle\Validator;


use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class OrderUsername extends Constraint
{

    public $message = "This username is already in use.";

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }


}