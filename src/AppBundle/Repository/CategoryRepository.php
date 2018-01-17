<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    
    public function getMainCategories()
    {
        $qb = $this->createQueryBuilder('category')
                ->select('category', 'firstLevel', 'secondLevel', 'thirdLevel', 'fourthLevel')
                ->leftJoin('category.children', 'firstLevel')
                ->leftJoin('firstLevel.children', 'secondLevel')
                ->leftJoin('secondLevel.children', 'thirdLevel')
                ->leftJoin('thirdLevel.children', 'fourthLevel')
                ->where('category.main = true');
        
        return $qb->getQuery()->getResult();
    }
    
    public function findAllQb()
    {
        $qb = $this->createQueryBuilder('category')
                ->select('category');
        return $qb;
    }

}
