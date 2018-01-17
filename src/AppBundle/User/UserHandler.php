<?php


namespace AppBundle\User;


use AppBundle\Entity\Order;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;

class UserHandler
{
    private $userManager;

    private $userFactory;

    public function __construct(UserManagerInterface $userManager, UserFactory $userFactory)
    {
        $this->userManager = $userManager;
        $this->userFactory = $userFactory;
    }

    public function handleCreateFromOrder(Order $order)
    {
        $user = $this->userFactory->createFromOrder($order);
        $this->userManager->updateUser($user);
    }

    public function handleUpdate(UserInterface $user)
    {
        $this->userManager->updateUser($user);
    }

}