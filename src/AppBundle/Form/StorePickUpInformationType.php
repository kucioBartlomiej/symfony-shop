<?php


namespace AppBundle\Form;


use AppBundle\Entity\StorePickUpInformation;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class StorePickUpInformationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', Type\TextType::class, [
                    'label' => 'First Name'
                ])
                ->add('lastName', Type\TextType::class, [
                    'label' => 'Last Name',
                ])
                ->add('phone', PhoneNumberType::class, [
                    'label' => 'Phone Number',
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            'data_class' => StorePickUpInformation::class,
        ]);

    }

}