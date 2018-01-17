<?php


namespace AppBundle\User;

use AppBundle\Entity\Order;
use FOS\UserBundle\Model\UserManagerInterface;

class UserFactory
{
    private $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function createFromOrder(Order $order)
    {
        $user = $this->userManager->createUser();
        $user->setPlainPassword($order->getCreateAccountInformation()->getPassword());
        $user->setUsername($order->getCreateAccountInformation()->getUsername());
        $user->setEmail($order->getDeliveryInformation()->getEmail());
        $user->addOrder($order);
        $user->setDeliveryInformation($order->getDeliveryInformation());

        return $user;
    }

}