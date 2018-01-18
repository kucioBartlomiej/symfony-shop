<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Category;

class FourthLevelCategoriesFixtures extends Fixture implements OrderedFixtureInterface {
    
    public function getOrder(): int {
        return 4;
    }
    
    

    public function load(ObjectManager $manager) {
        
        $fourthLevelCats = [
                ['name' => 'Fourth level 1'],
                ['name' => 'Fourth level 2'],
                ['name' => 'Fourth level 3'],
        ];
        
        foreach ($fourthLevelCats as $key => $cat) {
            
            for ($index2 = 0; $index2 < 3; $index2++) {
                
                for ($index1 = 0; $index1 < 3; $index1++) {
                
                    for ($index = 0; $index < 3; $index++) {
                        $category = new Category($this->getReference('thirdLevelCat_'.$index.$key. $index1));
                        $category->setName($cat['name']);
                        $manager->persist($category);
                        $this->addReference('fourthLevelCat_'.$key.$index.$index1.$index2, $category);
                    }

                }
                
            }  
            
        }
        
        $manager->flush();
        
    }

}
