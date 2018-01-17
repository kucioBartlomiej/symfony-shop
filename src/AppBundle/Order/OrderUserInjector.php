<?php


namespace AppBundle\Order;

use AppBundle\Entity\Order;
use AppBundle\Entity\User;

class OrderUserInjector
{
    public static function injectUser(Order $order, User $user)
    {
        $order->setUser($user);

        if ($user->getDeliveryInformation())
        {
            $order->setDeliveryInformation($user->getDeliveryInformation());
            $order->setStorePickUpInformation(
                OrderStorePickupInformationFactory::createFromDeliveryInformation($user->getDeliveryInformation())
            );
        }

        return $order;
    }
}