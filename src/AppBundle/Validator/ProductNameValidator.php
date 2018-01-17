<?php


namespace AppBundle\Validator;


use AppBundle\Entity\Product;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ProductNameValidator extends ConstraintValidator
{

    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param Product $object
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($object, Constraint $constraint)
    {
        $product = $this->objectManager->getRepository('AppBundle:Product')->findOneBySlug($object->getSlug());

        if ($product && $product->getId() != $object->getId())
        {
            $this->context->buildViolation($constraint->message)->atPath('name')->addViolation();
        }

    }
}