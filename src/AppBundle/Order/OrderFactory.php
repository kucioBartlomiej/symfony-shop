<?php

namespace AppBundle\Order;

use AppBundle\Cart\Cart;
use AppBundle\Entity\Order;
use AppBundle\Entity\User;
use AppBundle\Order\OrderProductFactory;
use Doctrine\Common\Collections\ArrayCollection;

class OrderFactory {
    
    private $orderProductFactory;
    
    public function __construct(OrderProductFactory $orderProductFactory) {
        $this->orderProductFactory = $orderProductFactory;
    }
    
    public function createFromCart(Cart $cart): Order
    {
        $orderProducts = $this->orderProductFactory->createMultipleFromCart($cart->getProducts());

        $order =  new Order(
            $cart->getTotalPrice(),
            $cart->getDeliveryMethod(),
            $cart->getSubTotalPrice(),
            $orderProducts
        );
        
        return $order;
    }

}
