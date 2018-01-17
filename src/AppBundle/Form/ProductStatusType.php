<?php

namespace AppBundle\Form;

use AppBundle\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProductStatusType extends AbstractType {
    
    public function configureOptions(OptionsResolver $resolver) {
        
        $resolver->setDefaults([
            'choices' => Product::STATUS_LIST,
        ]);
    }
    
    public function getParent() {
        return ChoiceType::class;
    }
}
