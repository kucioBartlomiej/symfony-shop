<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="order_product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderRepository")
 */
class OrderProduct {

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
     * @ORM\ManyToOne(targetEntity="Product")
     */
    private $product;

    /**
     * @var Order
     *
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="products")
     */
    private $order;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", length=11, scale=2)
     */
    private $totalProductPrice;


    public function __construct(
        Product $product,
        int $quantity
    ){
        $this->product = $product;
        $this->quantity = $quantity;
        $this->totalProductPrice = $product->getPrice() * $quantity;
    }


    public function getProduct(): Product
    {
        return $this->product;
    }


    public function getQuantity(): int
    {
        return $this->quantity;
    }


    public function getTotalProductPrice(): float
    {
        return $this->totalProductPrice;
    }

}
