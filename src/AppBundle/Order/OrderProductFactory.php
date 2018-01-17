<?php

namespace AppBundle\Order;

use AppBundle\Entity\OrderProduct;
use AppBundle\Cart\CartProduct;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;

class OrderProductFactory {
    
    private $manager;
    
    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }
    
    public function createFromCartProduct(CartProduct $cartProduct): OrderProduct
    {
        $product = $this->manager->merge($cartProduct->getProduct());

        return new OrderProduct(
            $product,
            $cartProduct->getQuantity()
         );
    }
    
    public function createMultipleFromCart(ArrayCollection $cartProducts): ArrayCollection
    {
        $orderProducts = new ArrayCollection();
        
        foreach ($cartProducts->getValues() as $cartProduct) {
            $orderProducts->add($this->createFromCartProduct($cartProduct));
        }
        
        return $orderProducts;
    }
    
}
