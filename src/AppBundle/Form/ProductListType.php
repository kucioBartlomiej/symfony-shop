<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;


class ProductListType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder->add('sortBy', ProductSortType::class, [
                        'label' => 'Sortowanie',
                        'data' => $options['params']['sortBy']
                    ])
                    ->add('perPage', PaginationPerPageType::class,[
                        'label' => 'Per Page',
                        'data' => (int)$options['params']['perPage']
                    ]);
        
        if (!empty($options['search'])) {
            $builder->add('search', Type\HiddenType::class, [
                    'data' => $options['search']
            ]);
        }
        
    }
    
    public function getBlockPrefix() {
        return '';
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => null,
            'csrf_protection' => false
        ]);
        $resolver->setRequired(['params']);
        
        $resolver->setDefined(['search']);
    }
    
}
