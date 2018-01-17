<?php


namespace AppBundle\Order;

use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\OrderUsername;

class OrderCreateAccount
{
    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"createAccount"})
     * @Assert\Length(min="3", max="30")
     * @OrderUsername(groups={"createAccount"})
     */
    private $username;

    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"createAccount"})
     */
    private $password;

    /**
     * @var string
     * @Assert\NotBlank(groups={"createAccount"})
     * @Assert\EqualTo(propertyPath="password")
     */
    private $passwordConfirmation;


    /**
     * @return string|null
     */
    public function getUsername()
    {
        return $this->username;
    }


    public function setUsername(string $username)
    {
        $this->username = $username;
    }


    /**
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }


    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getPasswordConfirmation()
    {
        return $this->passwordConfirmation;
    }


    public function setPasswordConfirmation(string $passwordConfirmation)
    {
        $this->passwordConfirmation = $passwordConfirmation;
    }

}