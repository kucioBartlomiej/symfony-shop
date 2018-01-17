<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class StockRepository extends EntityRepository
{

    public function getAdminStocks(array $parameters = array())
    {
        $qb = $this->createQueryBuilder('stock')
            ->select('stock', 'product')
            ->leftJoin('stock.product', 'product');

        if (!empty($parameters['nameLike'])) {
            $qb->andWhere('product.name LIKE :name')
                ->setParameter('name', '%'.$parameters['nameLike'].'%');
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
