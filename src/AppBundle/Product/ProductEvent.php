<?php

namespace AppBundle\Product;

use Symfony\Component\EventDispatcher\Event;
use AppBundle\Entity\Product;

class ProductEvent extends Event {
    
    private $product;


    public function __construct(Product $product)
    {
        $this->product = $product;
    }


    public function getProduct(): Product
    {
        return $this->product;
    }
    
}
