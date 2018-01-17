<?php

namespace AppBundle\Form;

use AppBundle\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class OrderStatusType extends AbstractType {
    
    public function configureOptions(OptionsResolver $resolver) {
        
        $resolver->setDefaults([
            'placeholder' => 'Choose Status',
            'choices' => Order::STATUS_LIST,
        ]);
    }
    
    public function getParent() {
        return Type\ChoiceType::class;
    }
}
