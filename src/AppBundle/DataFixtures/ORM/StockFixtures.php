<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Stock;

class StockFixtures extends Fixture implements OrderedFixtureInterface{

    public function getOrder(): int {
        return 7;
    }

    public function load(ObjectManager $manager) {
      
        for ($index = 1; $index < 50; $index++) {
            $stock = new Stock($this->getReference('product'.$index), rand(1,30));
            $manager->persist($stock);
        }
        
        $manager->flush();
    }

}
