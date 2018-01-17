<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class PaginationPerPageType extends AbstractType {
    
    const PER_PAGE_LIST = [
        '12' => 12,
        '24' => 24,
        '36' => 36,
        '48' => 48,
    ];
    
    public function configureOptions(OptionsResolver $resolver) {
        
        $resolver->setDefaults([
            'choices' => self::PER_PAGE_LIST,
        ]);
        
    }
    
    public function getParent() {
        return ChoiceType::class;
    }
    
}
