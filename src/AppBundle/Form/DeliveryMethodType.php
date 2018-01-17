<?php

namespace AppBundle\Form;

use AppBundle\Delivery\DeliveryData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DeliveryMethodType extends AbstractType {
   
    public function configureOptions(OptionsResolver $resolver) {
        
        $resolver->setDefaults([
            'choices' => DeliveryData::METHODS_LIST,
        ]);
    }
    
    public function getParent() {
        return ChoiceType::class;
    }
    
}
