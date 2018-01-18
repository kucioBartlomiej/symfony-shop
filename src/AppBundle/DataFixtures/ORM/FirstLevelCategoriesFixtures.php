<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Category;

class FirstLevelCategoriesFixtures extends Fixture implements OrderedFixtureInterface {
    
    public function getOrder() {
        return 1;
    }
    
    

    public function load(ObjectManager $manager) {
        
        $firstLevelCats = [
                ['name' => 'First level 1'],
                ['name' => 'First level 2'],
                ['name' => 'First level 3'],
        ];
        
        foreach ($firstLevelCats as $key => $cat) {
            
            $category = new Category(null);
            $category->setName($cat['name']);
            
            $manager->persist($category);
            $this->addReference('firstLevelCat_'.$key, $category);
        }
        
        $manager->flush();
        
    }

}
