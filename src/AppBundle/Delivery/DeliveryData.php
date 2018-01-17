<?php


namespace AppBundle\Delivery;


final class DeliveryData
{

    const METHODS_LIST = [
        'Parcel Delivery' => 'parcel',
        'Store Pickup' => 'store-pickup'
    ];

    const METHODS_COSTS = [
        'store-pickup' => 0,
        'parcel' => 15
    ];

}