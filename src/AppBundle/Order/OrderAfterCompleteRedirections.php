<?php


namespace AppBundle\Order;


use AppBundle\Entity\Order;
use AppBundle\Delivery\DeliveryData;

class OrderAfterCompleteRedirections
{

    public static function getRedirection(Order $order)
    {

        switch ($order->getDeliveryMethod())
        {
            case DeliveryData::METHODS_LIST['Parcel Delivery']:
                return 'order_payment';
                break;

            case DeliveryData::METHODS_LIST['Store Pickup']:
                return 'order_information';
                break;

            default:
                return null;
        }



    }
}