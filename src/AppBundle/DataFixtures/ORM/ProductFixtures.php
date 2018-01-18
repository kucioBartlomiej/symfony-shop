<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Product;

class ProductFixtures extends Fixture implements OrderedFixtureInterface {

    
    public function getOrder(): int {
        return 5;
    }

    public function load(ObjectManager $manager) {
        
        $prod = [
                'name' => 'product',
                'description' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here',
        ];
        
        for ($index = 1; $index < 50; $index++) {
           
            $product = new Product();
            $product->setName($prod['name'].$index);  
            $product->setDescription($prod['description']);
            $product->setPrice(floatval(rand(10,99).".".rand(10,99)));
            $product->setCategory($this->getReference('fourthLevelCat_000'.rand(0,2)));
            $product->setStatus('on-sale');
            
            $manager->persist($product);
            $this->addReference('product'.$index, $product);
        }
            
        $manager->flush();      

        
    }

}
