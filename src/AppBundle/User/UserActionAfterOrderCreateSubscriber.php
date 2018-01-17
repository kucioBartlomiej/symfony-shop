<?php


namespace AppBundle\User;


use AppBundle\Order\OrderEvent;
use AppBundle\Order\OrderEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserActionAfterOrderCreateSubscriber implements EventSubscriberInterface
{

    private $userHandler;

    public function __construct(UserHandler $userHandler)
    {
        $this->userHandler = $userHandler;
    }

    public static function getSubscribedEvents()
    {
        return [
            OrderEvents::AFTER_FLUSH => 'createUser',
        ];
    }

    public function createUser(OrderEvent $event)
    {
        $order = $event->getOrder();

        if($order->getCreateAccount())
        {
            $this->userHandler->handleCreateFromOrder($order);
        }

    }

}