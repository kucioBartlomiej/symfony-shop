<?php


namespace AppBundle\Order;


use AppBundle\Cart\Cart;
use AppBundle\Delivery\DeliveryData;
use Symfony\Component\HttpFoundation\Request;

class OrderValidationGroups
{

    public static function getGroups(Request $request, Cart $cart)
    {
        $formRequest = $request->request->get('order_checkout');

        $deliveryMethod = ($formRequest['deliveryMethod']) ? $formRequest['deliveryMethod']: $cart->getDeliveryMethod();

        switch ($deliveryMethod)
        {
            case DeliveryData::METHODS_LIST['Parcel Delivery']:

                if (!empty($formRequest['createAccount']))
                {
                    return ['parcelDelivery', 'createAccount'];
                }
                else
                {
                    return ['parcelDelivery'];
                }
                break;

            case DeliveryData::METHODS_LIST['Store Pickup']:
                return ['storePickup'];
                break;

            default:
                return ['Default'];
        }

    }


}