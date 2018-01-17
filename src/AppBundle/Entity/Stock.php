<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="stock")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StockRepository")
 */

class Stock {
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var Product
     * 
     * @ORM\OneToOne(targetEntity="Product", inversedBy="stock")
     */
    private $product;
    
    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    private $quantity;


    public function __construct(Product $product, int $productQuantity = 0) {
        $this->product = $product;
        $this->quantity = $productQuantity;
    }


    public function getId(): int
    {
        return $this->id;
    }


    public function getProduct(): Product
    {
        return $this->product;
    }


    public function getQuantity(): int
    {
        return $this->quantity;
    }


    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }
}
