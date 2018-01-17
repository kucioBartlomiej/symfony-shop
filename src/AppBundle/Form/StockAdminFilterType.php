<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class StockAdminFilterType extends AbstractType {
    
    
    const ORDER_BY_QUANTITY_LIST = [
        'Ascending' => 'quantity-asc',
        'Descending' => 'quantity-desc'
    ];
    
    public function buildForm(FormBuilderInterface $builder, array $options) {


        $builder->add('nameLike', Type\TextType::class, [
                        'label' => 'Product Name',
                        'data' => $options['params']['nameLike']
                    ])
                    ->add('orderByQuantity', Type\ChoiceType::class, [
                        'label' => 'Stock quantity',
                        'choices' => self::ORDER_BY_QUANTITY_LIST,
                        'data' => $options['params']['orderByQuantity'],
                        'placeholder' => 'Sort By'
                    ])
                    ->add('perPage', PaginationPerPageType::class, [
                        'label' => 'Orders per page',
                        'data' => (int)$options['params']['perPage']
                    ]);
        
    }
    
    public function getBlockPrefix() {
        return '';
    }
    
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'csrf_protection' => false
        ]);
        
        $resolver->setRequired(['params']);
    }
    
}
