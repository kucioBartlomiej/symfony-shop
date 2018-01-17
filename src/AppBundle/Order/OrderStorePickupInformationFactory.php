<?php


namespace AppBundle\Order;


use AppBundle\Entity\DeliveryInformation;
use AppBundle\Entity\StorePickUpInformation;

class OrderStorePickupInformationFactory
{
    public static function createFromDeliveryInformation(DeliveryInformation $deliveryInformation)
    {
        return new StorePickUpInformation(
            $deliveryInformation->getFirstName(),
            $deliveryInformation->getLastName(),
            $deliveryInformation->getPhone()
        );

    }
}