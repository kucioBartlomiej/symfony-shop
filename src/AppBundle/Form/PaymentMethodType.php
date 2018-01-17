<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PaymentMethodType extends AbstractType {
    
    const  PAYMENT_METHODS = [
        'Paypal' => 'paypal',
        'Bank Transfer' => 'bank'
    ];
   
    public function configureOptions(OptionsResolver $resolver) {
        
        $resolver->setDefaults([
            'choices' => self::PAYMENT_METHODS,
        ]);
    }
    
    public function getParent() {
        return ChoiceType::class;
    }
    
}
