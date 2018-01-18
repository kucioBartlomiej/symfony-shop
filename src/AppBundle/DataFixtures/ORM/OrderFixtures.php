<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Cart\CartManager;
use AppBundle\Cart\CartProduct;
use AppBundle\Delivery\DeliveryData;
use AppBundle\Form\PaymentMethodType;
use AppBundle\Order\OrderFactory;
use AppBundle\Order\OrderUserInjector;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class OrderFixtures extends Fixture implements OrderedFixtureInterface {

    private $cartManager;

    private $orderFactory;

    public function __construct(CartManager $cartManager, OrderFactory $orderFactory)
    {
        $this->cartManager = $cartManager;
        $this->orderFactory = $orderFactory;
    }

    public function getOrder(): int
    {
        return 9;
    }

    public function load(ObjectManager $manager) {


        $deliveryMethods = [
            DeliveryData::METHODS_LIST['Store Pickup'],
            DeliveryData::METHODS_LIST['Parcel Delivery']
        ];

        $paymentMethods = [
            PaymentMethodType::PAYMENT_METHODS['Bank Transfer'],
            PaymentMethodType::PAYMENT_METHODS['Paypal']
        ];
        
        for ($index = 0; $index < 30; $index++)
        {
            $user = $this->getReference('user'.rand(1,8));

            $order = $this->orderFactory->createFromCart($this->getRandomCart());
            $order->setDeliveryMethod($deliveryMethods[rand(0,1)]);
            $order = OrderUserInjector::injectUser($order, $user);
            if ($order->getDeliveryMethod() == $deliveryMethods[1])
            {
                $order->setPaymentMethod($paymentMethods[rand(0,1)]);
            }
            
            $manager->persist($order);
            $this->addReference('order'.$index, $order);
        }
        
        $manager->flush();
        
    }

    private function getRandomCart()
    {
        $this->cartManager->clearCart();
        $this->cartManager->checkCart();

        for ($i = 0; $i <= 4; $i++)
        {
            $cartProduct = new CartProduct($this->getReference('product'.rand(1,49)), rand(1,5));
            $this->cartManager->addToCart($cartProduct);
        }

        return $this->cartManager->checkCart();

    }

}
