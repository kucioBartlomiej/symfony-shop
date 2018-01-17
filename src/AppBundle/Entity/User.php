<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Order[]
     *
     * @ORM\OneToMany(targetEntity="Order", mappedBy="user")
     */
    private $orders;

    /**
     * @var DeliveryInformation
     *
     * @ORM\Embedded(class="DeliveryInformation")
     * @Assert\Valid
     */
    private $deliveryInformation;


    public function __construct()
    {
        parent::__construct();
        $this->orders = new ArrayCollection();
    }

    /**
     * @return Order[]|Collection|null
     */
    public function getOrders()
    {
        return $this->orders;
    }

    public function addOrder(Order $order)
    {
        $order->setUser($this);
        $this->orders->add($order);
    }


    public function getDeliveryInformation(): DeliveryInformation
    {
        return $this->deliveryInformation;
    }


    public function setDeliveryInformation(DeliveryInformation $deliveryInformation)
    {
        $this->deliveryInformation = $deliveryInformation;
    }
}
