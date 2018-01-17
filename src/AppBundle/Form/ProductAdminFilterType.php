<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class ProductAdminFilterType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder->add('nameLike', Type\TextType::class, [
                    'label' => 'Product Name',
                    'data' => $options['params']['nameLike']
                ])
                ->add('category', CategoryListType::class,[
                    'data' => (int)$options['params']['category']
                ])
                ->add('status', ProductStatusType::class, [
                    'placeholder' => 'All',
                    'label' => 'Status',
                    'data' => $options['params']['status']
                ])
                ->add('perPage', PaginationPerPageType::class, [
                    'label' => 'Products per page',
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
        
        $resolver->setRequired(['params','em']);
    }
    
}
