<?php

namespace AppBundle\Product;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use AppBundle\Entity\Product;

class ProductHandler {
    
    private $dispatcher;
    
    private $manager;
    
    public function __construct(EventDispatcherInterface $dispatcher, ObjectManager $manager)
    {
        $this->dispatcher = $dispatcher;
        $this->manager = $manager;
    }
    
    public function handleCreate(Product $product)
    {
        $this->dispatcher->dispatch(ProductEvents::PRE_PERSIST, new ProductEvent($product));
        $this->manager->persist($product);
        $this->manager->flush();
    }
    
    public function handleUpdate(Product $product)
    {
        $this->dispatcher->dispatch(ProductEvents::PRE_FLUSH, new ProductEvent($product));
        $this->manager->flush();
    }
    
    public function handleRemove(Product $product)
    {
        $this->dispatcher->dispatch(ProductEvents::PRE_REMOVE, new ProductEvent($product));
        $this->manager->remove($product);
        $this->manager->flush();
    }

}
