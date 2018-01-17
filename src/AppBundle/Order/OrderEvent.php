<?php


namespace AppBundle\Order;


use AppBundle\Entity\Order;
use Symfony\Component\EventDispatcher\Event;

class OrderEvent extends Event
{
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }
}