<?php


namespace AppBundle\Entity;

use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use libphonenumber\PhoneNumber;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Embeddable
 */
class StorePickUpInformation
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(groups={"storePickup"})
     * @Assert\Length(max=120)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(groups={"storePickup"})
     * @Assert\Length(max=120)
     */
    private $lastName;

    /**
     * @var PhoneNumber
     *
     * @ORM\Column(type="phone_number", nullable=true)
     * @Assert\NotBlank(message="Enter Phone Number", groups={"storePickup"})
     * @AssertPhoneNumber()
     */
    private $phone;


    public function __construct(
        string $firstName = null,
        string $lastName = null,
        PhoneNumber $phone = null
    ){
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phone = $phone;
    }

    /**
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->firstName;
    }


    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName()
    {
        return $this->lastName;
    }


    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return PhoneNumber|null
     */
    public function getPhone()
    {
        return $this->phone;
    }


    public function setPhone(PhoneNumber $phone)
    {
        $this->phone = $phone;
    }
}