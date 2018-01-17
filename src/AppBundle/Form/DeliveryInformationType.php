<?php

namespace AppBundle\Form;

use AppBundle\Entity\DeliveryInformation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;

class DeliveryInformationType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
    
        $builder->add('companyName', Type\TextType::class, [
                        'label' => 'Company Name (optional)'
                    ])
                    ->add('firstName', Type\TextType::class, [
                        'label' => 'First Name'
                    ])
                    ->add('lastName', Type\TextType::class, [
                        'label' => 'Last Name'
                    ])
                    ->add('phone', PhoneNumberType::class, [
                        'label' => 'Phone Number',
                    ])
                    ->add('adress', Type\TextType::class, [
                        'label' => 'Adress'
                    ])
                    ->add('postcode', Type\TextType::class, [
                        'label' => 'Zip Code'
                    ])
                    ->add('city', Type\TextType::class, [
                        'label' => 'City'
                    ])
                    ->add('email', Type\EmailType::class,[
                        'label' => 'Email'
                    ]);
        
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
           'data_class' => DeliveryInformation::class,
        ]);
       
    }
    
}
