<?php


namespace AppBundle\Validator;


use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class OrderIsEmailRegistratedValidator extends ConstraintValidator
{

    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param Order $object
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($object, Constraint $constraint)
    {

        $user = $this->objectManager->getRepository(User::class)->findOneByEmail($object->getDeliveryInformation()->getEmail());

        if ($user)
        {
            $this->context->buildViolation($constraint->message)->atPath('createAccount')->addViolation();
        }

    }
}