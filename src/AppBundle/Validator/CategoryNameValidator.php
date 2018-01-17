<?php


namespace AppBundle\Validator;


use AppBundle\Entity\Category;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CategoryNameValidator extends ConstraintValidator
{

    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param Category $object
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($object, Constraint $constraint)
    {
        if ($object->isMain())
        {
            $category = $this->objectManager->getRepository('AppBundle:Category')->findOneBy([
               'main' => true,
               'slug' => $object->getSlug()
            ]);

            if ($category)
            {
                $this->context->buildViolation($constraint->message)->atPath('name')->addViolation();
            }
        }
        else
        {
            $categories = $this->objectManager->getRepository('AppBundle:Category')->findBy([
                'main' => false,
                'slug' => $object->getSlug()
            ]);

            foreach ($categories as $category)
            {
                if ($category->getParent()->getId() == $object->getParent()->getId())
                {
                    $this->context->buildViolation($constraint->message)->atPath('name')->addViolation();
                }
            }


        }
    }
}