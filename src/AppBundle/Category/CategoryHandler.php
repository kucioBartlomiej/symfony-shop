<?php

namespace AppBundle\Category;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Category;

class CategoryHandler {
    
    private $manager;


    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }

    
    public function handleCreate(Category $category)
    {
        $this->manager->persist($category);
        $this->manager->flush();

    }


    public function handleUpdate()
    {
        $this->manager->flush();
    }


    public function handleRemove(Category $category)
    {
        $this->manager->remove($category);
        $this->manager->flush();
    }
    
}
