<?php

namespace AppBundle\Order;

use AppBundle\Entity\Order;
use AppBundle\Mailer\MailerService;
use AppBundle\Mailer\Message\OrderCreateMessage;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class OrderHandler {
    
    private $manager;

    private $dispatcher;

    private $mailer;
    
    public function __construct(ObjectManager $manager, EventDispatcherInterface $dispatcher, MailerService $mailer) {
        $this->manager = $manager;
        $this->dispatcher = $dispatcher;
        $this->mailer = $mailer;
    }
    
    public function handleCreate(Order $order)
    {
        $this->manager->persist($order);
        $this->manager->flush();
        $this->dispatcher->dispatch(OrderEvents::AFTER_FLUSH, new OrderEvent($order));
//        $this->mailer->sendEmailMessage(OrderCreateMessage::createFromOrder($order));
    }
    
}
