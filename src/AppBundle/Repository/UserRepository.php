<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    
    
    public function getAdminUsersList(array $parameters = [])
    {
        $qb = $this->createQueryBuilder('user')
                ->select('user', 'orders', 'personalData', 'companyData')
                ->leftJoin('user.orders', 'orders')
                ->leftJoin('user.personalData', 'personalData')
                ->leftJoin('user.companyData', 'companyData');
        
        if (!empty($parameters['username'])) {
            $qb->where('user.username = :username')
                  ->setParameter('username', $parameters['username']);
        }
        
        if (!empty($parameters['email'])) {
            $qb->where('user.email = :email')
                  ->setParameter('email', $parameters['email']);
        }
        
        
        return $qb->getQuery()->getResult();
    }
    
    
    
}
