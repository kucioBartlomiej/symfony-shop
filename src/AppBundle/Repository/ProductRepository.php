<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    
    public function searchByString($string, array $parameters = [])
    {
        $qb = $this->createQueryBuilder('product')
                ->select('product', 'category', 'stock', 'picture')
                ->leftJoin('product.category', 'category')
                ->leftJoin('product.stock', 'stock')
                ->leftJoin('product.picture', 'picture')
                ->where('product.status = :status')
                ->setParameter('status', 'on-sale')
                ->andWhere('product.name LIKE :search OR product.description LIKE :search')
                ->setParameter('search', '%'.$string.'%');
        
        $qb = $this->sortByParameters($qb, $parameters);
        
        return $qb->getQuery()->getResult();
    }
    
    public function searchByCategoryGroup(array $categories = null, array $parameters = [])
    {
       $qb = $this->createQueryBuilder('product')
                ->select('product', 'category', 'stock', 'picture')
                ->leftJoin('product.category', 'category')
                ->leftJoin('product.stock', 'stock')
                ->leftJoin('product.picture', 'picture')
                ->where('product.status = :status')
                ->setParameter('status', 'on-sale');
       
        if ($categories !== null) {
            $qb->andwhere($qb->expr()->in('product.category', ':categories'))
                ->setParameter('categories', $categories);
        }
        
        $qb = $this->sortByParameters($qb, $parameters);
       
          return $qb->getQuery()->getResult();      
    }
    
    private function sortByParameters($qb, array $parameters = [])
    {
        if (!empty($parameters['sortBy'])) {
            if ('name-asc' == $parameters['sortBy']){
                $qb->orderBy('product.name', 'ASC');
            }
            elseif ('name-desc' == $parameters['sortBy']) {
                $qb->orderBy('product.name', 'DESC');
            }
            elseif ('price-asc' == $parameters['sortBy']) {
                $qb->orderBy('product.price', 'ASC');
            }
            elseif ('price-desc' == $parameters['sortBy']) {
                $qb->orderBy('product.price', 'DESC');
            }
        }
        
       return $qb;
    }
    
    
    public function getAdminProductsList(array $parameters = [])
    {
        $qb = $this->createQueryBuilder('product')
                ->select('product', 'category', 'stock', 'picture')
                ->leftJoin('product.category', 'category')
                ->leftJoin('product.stock', 'stock')
                ->leftJoin('product.picture', 'picture');

        if (!empty($parameters['status'])) {
            $qb->where('product.status = :status')
                  ->setParameter('status', $parameters['status']);
        }
        
        if (!empty($parameters['category'])) {
            $qb->andWhere('product.category = :category')
               ->setParameter('category', $parameters['category']);
        }
        
        if (!empty($parameters['nameLike'])) {
            $qb->andWhere('product.name LIKE :name')
               ->setParameter('name', '%'.$parameters['nameLike'].'%');
        }
        
        if (!empty($parameters['productId'])) {
            $qb->andWhere('product.id = :productId')
               ->setParameter('productId', $parameters['productId']);
        }
        
        if (!empty($parameters['orderByQuantity'])) {
            if ('quantity-asc' == $parameters['orderByQuantity']){
                $qb->orderBy('stock.quantity', 'ASC');
            }
            elseif ('quantity-desc' == $parameters['orderByQuantity']) {
                $qb->orderBy('stock.quantity', 'DESC');
            }
        }
        
        return $qb->getQuery()->getResult();
    }
    
    
}
