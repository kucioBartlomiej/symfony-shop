<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use AppBundle\Entity\Category;


class CategoryManageType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {

        
        $builder->add('name', Type\TextType::class, [
                    'label' => 'Name'
                ]);
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Category::class,
            ]);
    }
}
