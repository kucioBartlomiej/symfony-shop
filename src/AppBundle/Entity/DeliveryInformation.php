<?php

namespace AppBundle\Entity;

use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use libphonenumber\PhoneNumber;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Embeddable
 */
class DeliveryInformation {

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $companyName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(message="Enter First Name", groups={"parcelDelivery", "userInformationUpdate"})
     * @Assert\Length(max=120)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(message="Enter Last Name", groups={"parcelDelivery", "userInformationUpdate"})
     * @Assert\Length(max=120)
     */
    private $lastName;

    /**
     * @var PhoneNumber
     *
     * @ORM\Column(type="phone_number", nullable=true)
     * @Assert\NotBlank(message="Enter Phone Number", groups={"parcelDelivery", "userInformationUpdate"})
     * @AssertPhoneNumber()
     */
    private $phone;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(message="Enter Adress", groups={"parcelDelivery", "userInformationUpdate"})
     */
    private $adress;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(message="Enter City", groups={"parcelDelivery", "userInformationUpdate"})
     */
    private $city;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(message="Enter Zip Code", groups={"parcelDelivery", "userInformationUpdate"})
     * @Assert\Length(max=10)
     */
    private $postcode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Email()
     * @Assert\NotBlank(message="Enter Email", groups={"parcelDelivery", "userInformationUpdate"})
     */
    private $email;


    /**
     * @return string|null
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }


    public function setCompanyName(string $companyName)
    {
        $this->companyName = $companyName;
    }


    /**
     * @return string|null
     */
    public function getAdress()
    {
        return $this->adress;
    }


    public function setAdress(string $adress)
    {
        $this->adress = $adress;
    }


    /**
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }



    public function setCity(string $city)
    {
        $this->city = $city;
    }


    /**
     * @return string|null
     */
    public function getPostcode()
    {
        return $this->postcode;
    }


    public function setPostcode(string $postcode)
    {
        $this->postcode = $postcode;
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


    public function setPhone($phone)
    {
        $this->phone = $phone;
    }


    /**
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }


    public function setEmail(string $email)
    {
        $this->email = $email;
    }

}
