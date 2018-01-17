<?php

namespace AppBundle\Form;

use AppBundle\Entity\Stock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class StockUpdateType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder->add('quantity', IntegerType::class, [
                        'label' => 'Quantity',
                    ]);
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Stock::class,
            ]);
    }
    
}
