<?php

namespace AppBundle\Cart;

use AppBundle\Delivery\DeliveryData;
use Doctrine\Common\Collections\ArrayCollection;

class Cart {

    /**
     * @var CartProduct[]|ArrayCollection
     */
    private $products;
    
    /**
     * @var float
     */
    private $totalPrice;
    
    /**
     * @var string
     */
    private $deliveryMethod;
    
    /**
     * @var float
     */
    private $deliveryPrice;
    
    /**
     * @var float
     */
    private $subTotalPrice = 0;

    
    public function __construct() {
        $this->products = new ArrayCollection();
        $this->deliveryMethod = DeliveryData::METHODS_LIST['Parcel Delivery'];
        $this->deliveryPrice = DeliveryData::METHODS_COSTS[$this->deliveryMethod];
    }


    public function calculateTotalPrice()
    {
        $this->calculateSubTotal();
        $this->totalPrice = $this->subTotalPrice + $this->deliveryPrice;
    }


    private function calculateSubTotal()
    {
        $this->subTotalPrice = 0;

        foreach ($this->products->getValues() as $cartProduct)
        {
            $this->subTotalPrice += $cartProduct->getTotalPrice();
        }
    }


    public function addNewProduct(CartProduct $cartProduct)
    {
        $this->products->set($cartProduct->getId(), $cartProduct);
        $this->calculateTotalPrice();
    }


    public function increaseProductQuantity(CartProduct $cartProduct)
    {
        $this->products->get($cartProduct->getId())->increaseQuantity($cartProduct->getQuantity());
        $this->calculateTotalPrice();
    }


    public function updateProductQuantity(array $productData)
    {
        $this->products->get($productData['productId'])->updateQuantity($productData['quantity']);
        $this->calculateTotalPrice();
    }


    public function removeProduct(int $productId)
    {
        $this->products->remove($productId);
        $this->calculateTotalPrice();
    }


    public function productsCount(): int
    {
        return $this->products->count();
    }
    
    /**
     * @return CartProduct[]|ArrayCollection
     */
    public function getProducts(): ArrayCollection
    {
        return $this->products;
    }


    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }
    

    public function getDeliveryPrice(): float
    {
        return $this->deliveryPrice;
    }
    

    public function getSubTotalPrice(): float
    {
        return $this->subTotalPrice;
    }


    public function getDeliveryMethod(): string
    {
        return $this->deliveryMethod;
    }

}
