<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class OrderAdminFilterType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder->add('orderId', Type\NumberType::class, [
                        'label' => 'Order Id',
                        'data' => (!empty($options ['params']['orderId'])) ? (int)$options ['params']['orderId'] : null
                    ])
                    ->add('status', OrderStatusType::class, [
                        'label' => 'Status',
                        'data' => $options['params']['status']
                    ])
                    ->add('perPage', PaginationPerPageType::class, [
                        'label' => 'Per Page',
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
