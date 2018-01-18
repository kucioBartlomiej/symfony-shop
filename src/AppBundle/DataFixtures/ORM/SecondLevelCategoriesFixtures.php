<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Category;

class SecondLevelCategoriesFixtures extends Fixture implements OrderedFixtureInterface {
    
    public function getOrder(): int {
        return 2;
    }
    
    

    public function load(ObjectManager $manager) {
        
        $secondLevelCats = [
                ['name' => 'Second level 1'],
                ['name' => 'Second level 2'],
                ['name' => 'Second level 3'],
        ];
        
        foreach ($secondLevelCats as $key => $cat) {
            
            for ($index = 0; $index < 3; $index++) {
                $category = new Category($this->getReference('firstLevelCat_'.$index));
                $category->setName($cat['name']);
                $manager->persist($category);
                $this->addReference('secondLevelCat_'.$key.$index, $category);
            }
        }
        
        $manager->flush();
        
    }

}
