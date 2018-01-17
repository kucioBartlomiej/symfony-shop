<?php

namespace AppBundle\Stock;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use AppBundle\Product\ProductEvents;
use AppBundle\Product\ProductEvent;
use AppBundle\Entity\Stock;

class StockCreateSubscriber implements EventSubscriberInterface
{
    
    public static function getSubscribedEvents(): array
    {
        return [
            ProductEvents::PRE_PERSIST => 'createStock'
        ];
    }
    
    public function createStock(ProductEvent $event)
    {
        $product = $event->getProduct();
        $stock = new Stock($product);
        $product->setStock($stock);
    }

}
