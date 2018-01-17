<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class OrderRepository extends EntityRepository
{
    
    public function getAdminOrderList(array $parameters = [])
    {
        $qb = $this->createQueryBuilder('orders')
                ->select('orders', 'user')
                ->leftJoin('orders.user', 'user', 'orderProducts')
                ->leftJoin('orders.products', 'orderProducts')
                ->orderBy('orders.orderDate', 'DESC');
        
        if (!empty($parameters['status'])) {
            $qb->andwhere('orders.status = :status')
                  ->setParameter('status', $parameters['status']);
        }
        
        if (!empty($parameters['orderId'])) {
            $qb->andWhere('orders.id LIKE :orderId')
               ->setParameter('orderId', $parameters['orderId']);
        }
        return $qb->getQuery()->getResult();
    }
    
    
    
}
