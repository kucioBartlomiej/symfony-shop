<?php


namespace AppBundle\Validator;


use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class OrderUsernameValidator extends ConstraintValidator
{

    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {

        $user = $this->objectManager->getRepository(User::class)->findOneByUsername($value);

        if ($user)
        {
            $this->context->buildViolation($constraint->message)->addViolation();
        }

    }
}