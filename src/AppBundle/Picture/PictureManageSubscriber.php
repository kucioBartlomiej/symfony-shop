<?php

namespace AppBundle\Picture;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use AppBundle\Product\ProductEvents;
use AppBundle\Product\ProductEvent;
use AppBundle\Picture\PictureFactory;
use AppBundle\Picture\PictureHandler;

class PictureManageSubscriber implements EventSubscriberInterface {
    
    private $pictureHandler;
    
    public function __construct(PictureHandler $pictureHandler) {
        $this->pictureHandler = $pictureHandler;
    }
    
    public static function getSubscribedEvents(): array
    {
        return [
            ProductEvents::PRE_PERSIST => 'createPicture',
            ProductEvents::PRE_FLUSH => 'createPicture',
        ];
    }
    
    public function createPicture(ProductEvent $event)
    {
        $product = $event->getProduct();
        
        if ($product->getPictureFile() !== null ) {
            $picture = PictureFactory::createFromProduct($product);
            $product->setPicture($picture);
            $this->pictureHandler->uploadPicture($picture);
        }
        
    }
    
}
