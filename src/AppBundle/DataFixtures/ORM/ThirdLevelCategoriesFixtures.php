<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Category;

class ThirdLevelCategoriesFixtures extends Fixture implements OrderedFixtureInterface {
    
    public function getOrder(): int {
        return 3;
    }
    
    

    public function load(ObjectManager $manager) {
        
        $thirdLevelCats = [
                ['name' => 'Third level 1'],
                ['name' => 'Third level 2'],
                ['name' => 'Third level 3'],
        ];
        
        foreach ($thirdLevelCats as $key => $cat) {
         
            for ($index1 = 0; $index1 < 3; $index1++) {
               
                for ($index = 0; $index < 3; $index++) {
                $category = new Category($this->getReference('secondLevelCat_'.$key.$index));
                $category->setName($cat['name']);
                $manager->persist($category);
                $this->addReference('thirdLevelCat_'.$key.$index.$index1, $category);
            }
                
            }
            
            
        }
        
        $manager->flush();
        
    }

}
