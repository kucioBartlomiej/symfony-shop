<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class ProductSortType extends AbstractType {
   
    const SORT_BY_LIST = [
        'Sort:' => 'default',
        'Name A-Z' => 'name-asc',
        'Name Z-A' => 'name-desc',
        'Price Ascending' => 'price-asc',
        'Price Descending' => 'price-desc',
    ];
    
    public function configureOptions(OptionsResolver $resolver) {
        
        $resolver->setDefaults([
            'choices' => self::SORT_BY_LIST,
        ]);
        
    }
    
    public function getParent() {
        return Type\ChoiceType::class;
    }
    
}
