<?php

namespace AppBundle\Form;

use AppBundle\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class OrderCheckoutType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $order = $builder->getData();

        $builder->add('deliveryMethod', DeliveryMethodType::class, [
                    'label' => 'Delivery Method'
                ])
                ->add('informationFromUser', TextareaType::class, [
                    'label' => 'Information form User',
                ]);

        /**
         * Parcel Delivery
         */
        $builder->add('deliveryInformation', DeliveryInformationType::class, [
                    'label' => null
                ])
                ->add('paymentMethod', PaymentMethodType::class, [
                    'placeholder' => 'Choose Payment Method'
                ]);

        if (!$order->getUser())
        {
            $builder->add('createAccount', CheckboxType::class, [
                'label' => 'Create Account'
            ]);
        }
        else
        {
            $builder->add('createAccount', HiddenType::class);
        }

        /**
         * Create Account Information
         */
        $builder->add('createAccountInformation', OrderCreateAccountType::class);


        /**
         * Store Pickup;
         */
        $builder->add('storePickUpInformation', StorePickUpInformationType::class, [
                    'label' => null,
                ]);

    }
    
    
    public function configureOptions(OptionsResolver $resolver) {

        $validation = function (Options $options){
            return $options['validation_groups'];
        };

        $resolver->setDefaults([
            'data_class' => Order::class,
            'validation_groups' => $validation
        ]);

    }
}
