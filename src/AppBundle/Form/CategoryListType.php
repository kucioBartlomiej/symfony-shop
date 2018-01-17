<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Repository\CategoryRepository;
use AppBundle\Entity\Category;

class CategoryListType extends AbstractType{
    
    public function configureOptions(OptionsResolver $resolver) {
        
        $resolver->setDefaults([
            'placeholder' => 'All',
            'label' => 'Category',
            'choice_label' => 'name',
            'class' => Category::class,
            'query_builder' => function(CategoryRepository $cr) {  
                    return $cr->findAllQb();
             },
        ]);
             
    }

    public function getParent() {
        return EntityType::class;
    }
    
}
