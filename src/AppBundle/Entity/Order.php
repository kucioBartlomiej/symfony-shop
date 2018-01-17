<?php

namespace AppBundle\Entity;

use AppBundle\Order\OrderCreateAccount;
use AppBundle\Delivery\DeliveryData;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\OrderIsEmailRegistrated;


/**
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderRepository")
 * @ORM\HasLifecycleCallbacks()
 * @OrderIsEmailRegistrated(groups={"createAccount"})
 */
class Order {

    const STATUS_LIST = [
        'Waiting for Payment' => 'waiting-for-payment',
        'Waiting in Local Store' => 'waiting-in-local-store',
        'Paid' => 'paid',
        'Send' => 'send'
    ];

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private $user;

    /**
     * @var OrderProduct[]|Collection
     *
     * @ORM\OneToMany(targetEntity="OrderProduct", mappedBy="order", cascade={"persist", "remove"})
     */
    private $products;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", length=11, scale=2)
     */
    private $subTotalPrice;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", length=11, scale=2)
     */
    private $totalPrice;

     /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $deliveryMethod;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", length=11, scale=2, nullable=true)
     */
    private $deliveryPrice;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $status;

     /**
      * @var \DateTime
      *
     * @ORM\Column(type="datetime")
     */
    private $orderDate;

     /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $informationFromUser;

     /**
     *  @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(groups={"parcelDelivery"})
     */
    private $paymentMethod;

    /**
     * @var DeliveryInformation
     *
     * @ORM\Embedded(class="DeliveryInformation")
     * @Assert\Valid
     */
    private $deliveryInformation;


    /**
     * @var StorePickUpInformation
     *
     * @ORM\Embedded(class="StorePickUpInformation")
     * @Assert\Valid
     */
    private $storePickUpInformation;


    /**
     * @var boolean
     */
    private $createAccount;

    /**
     * @var OrderCreateAccount
     * @Assert\Valid
     */
    private $createAccountInformation;


    public function __construct(
        float $totalPrice,
        string $deliveryMethod,
        float $subTotalPrice,
        ArrayCollection $products
    ) {
        $this->totalPrice = $totalPrice;
        $this->deliveryMethod = $deliveryMethod;
        $this->subTotalPrice = $subTotalPrice;
        $this->createAccountInformation = new OrderCreateAccount();
        $this->products = $products;
    }



    private function setDefaultStatus(string $deliveryMethod)
    {
        if ($deliveryMethod == DeliveryData::METHODS_LIST['Parcel Delivery'])
        {
            $this->status = self::STATUS_LIST['Waiting for Payment'];
        }
        elseif ($deliveryMethod == DeliveryData::METHODS_LIST['Store Pickup'])
        {
            $this->status = self::STATUS_LIST['Waiting in Local Store'];
        }
    }


    private function setDeliveryPrice(string $deliveryMethod)
    {
        if ($deliveryMethod == DeliveryData::METHODS_LIST['Parcel Delivery'])
        {
            $this->deliveryPrice = DeliveryData::METHODS_COSTS['parcel'];
        }
        elseif ($deliveryMethod == DeliveryData::METHODS_LIST['Store Pickup'])
        {
            $this->deliveryPrice = DeliveryData::METHODS_COSTS['store-pickup'];
        }
    }

    /**
     * @ORM\PrePersist
     */
    public function setOrderDate()
    {
        $this->orderDate = new \DateTime();
    }


    public function setDeliveryMethod(string $deliveryMethod)
    {
        $this->deliveryMethod = $deliveryMethod;
        $this->setDefaultStatus($deliveryMethod);
        $this->setDeliveryPrice($deliveryMethod);
    }


    public function getDeliveryMethod(): string
    {
        return $this->deliveryMethod;
    }


    public function getDeliveryMethodDisplay(): string
    {
        foreach (DeliveryData::METHODS_LIST as $key => $value)
        {
            if ($this->deliveryMethod == $value)
            {
                return $key;
            }
        }
        return $this->deliveryMethod;
    }


    public function setDeliveryInformation(DeliveryInformation $deliveryInformation)
    {
        $this->deliveryInformation = $deliveryInformation;
    }


    public function getDeliveryInformation(): DeliveryInformation
    {
        return $this->deliveryInformation;
    }


    /**
     * @return string | null
     */
    public function getInformationFromUser()
    {
        return $this->informationFromUser;
    }


    public function setInformationFromUser(string $informationFromUser)
    {
        $this->informationFromUser = $informationFromUser;
    }


    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return User|null
     */
    public function getUser()
    {
        return $this->user;
    }


    public function setUser(User $user)
    {
        $this->user = $user;
    }


    public function getProducts(): Collection
    {
        return $this->products;
    }



    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }


    public function getDisplayStatus(): string
    {
        foreach (self::STATUS_LIST as $key => $value)
        {
            if ($this->status == $value)
            {
                return $key;
            }
        }
        return $this->status;
    }


    public function getStatus(): string
    {
        return $this->status;
    }


    public function setStatus(string $status)
    {
        $this->status = $status;
    }


    public function getOrderDate(): \DateTime
    {
        return $this->orderDate;
    }

    /**
     * @return string|null
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }


    public function setPaymentMethod(string $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @return bool|null
     */
    public function getCreateAccount()
    {
        return $this->createAccount;
    }


    public function setCreateAccount(bool $createAccount)
    {
        $this->createAccount = $createAccount;
    }


    public function getStorePickUpInformation(): StorePickUpInformation
    {
        return $this->storePickUpInformation;
    }


    public function setStorePickUpInformation(StorePickUpInformation $storePickUpInformation)
    {
        $this->storePickUpInformation = $storePickUpInformation;
    }

    /**
     * @return OrderCreateAccount|null
     */
    public function getCreateAccountInformation()
    {
        return $this->createAccountInformation;
    }


    public function setCreateAccountInformation(OrderCreateAccount $createAccountInformation)
    {
        $this->createAccountInformation = $createAccountInformation;
    }

}
