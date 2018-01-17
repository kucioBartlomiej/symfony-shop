<?php


namespace AppBundle\Mailer\Message;

use AppBundle\Entity\Order;

class OrderCreateMessage extends Message
{
    public static function createFromOrder(Order $order)
    {
        return new self(
            'New Order',
            $order->getDeliveryInformation()->getEmail(),
            'orderTemplate.html.twig',
            ['order' => $order]
        );
    }
}