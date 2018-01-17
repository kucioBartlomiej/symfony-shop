<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use AppBundle\Entity\Product;


class ProductEditType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
         
        $category = $builder->getData()->getCategory();
        
        $builder->add('name', Type\TextType::class, [
                    'label' => 'Name'
                ])
                ->add('category', CategoryListType::class,[
                    'label' => 'Category',
                    'placeholder' => null,
                    'data' => ($category !== null) ? $category->getId() : null
                ])
                ->add('description', Type\TextareaType::class, [
                    'label' => 'Description',
                ])
                ->add('price', Type\MoneyType::class, [
                    'label' => 'Price',
                    'currency' => false,
                ])
                ->add('status', ProductStatusType::class, [
                    'label' => 'Status',
                ])
                 ->add('pictureFile', Type\FileType::class,[
                    'label' => 'Picture File',
                ]);
    }
     
     
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'validation_groups' => ['EditProduct']
        ]);
    }
     
}


