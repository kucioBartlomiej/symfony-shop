<?php

namespace AppBundle\Cart;

use AppBundle\Entity\Product;

class CartProduct {
    
    /**
     * @var Product 
     */
    private $product;
    
    /**
     * @var int 
     */
    private $quantity;
    
    /**
     * @var float 
     */
    private $totalPrice;


    public function __construct(Product $product, int $quantity) {
        $this->product = $product;
        $this->quantity = $quantity;
        $this->calculatePrice();
    }

    private function calculatePrice()
    {
        $this->totalPrice = $this->product->getPrice() * $this->quantity;
    }


    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }


    public function getProduct(): Product
    {
        return $this->product;
    }


    public function getQuantity(): int
    {
        return $this->quantity;
    }


    public function updateQuantity(int $quantity)
    {
        $this->quantity = $quantity;
        $this->calculatePrice();
    }


    public function increaseQuantity(int $quantity)
    {
        $this->quantity += $quantity;
        $this->calculatePrice();
    }


    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }


    public function getId(): int
    {
        return $this->getProduct()->getId();
    }

}
