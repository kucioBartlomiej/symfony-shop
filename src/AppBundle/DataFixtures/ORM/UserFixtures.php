<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\DeliveryInformation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use libphonenumber\PhoneNumber;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;



class UserFixtures extends Fixture implements OrderedFixtureInterface, ContainerAwareInterface {
    
    private $container;
        
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder(): int {
        return 8;
    }

    public function load(ObjectManager $manager) {

        $users = [
            [
                'username' => "admin",
                'email' => "admin@user.com",
                'password' => "asd123321",
                'deliveryInformation' => [
                    'first_name' => "Admin",
                    'last_name' => "Admin",
                    'birthday' => "1961-03-24",
                    'phone' => "+1 9129885050",
                    'adress' => "3047 Better Street",
                    'postcode' => "GA 31401",
                    'country' => "US",
                    'city' => "Savannah",
                ],
                'role' => ['ROLE_ADMIN']
            ],
            [
                'username' => "vinlane",
                'email' => "user1@user.com",
                'password' => "strongpassword",
                'deliveryInformation' => [
                    'first_name' => "Vincent",
                    'last_name' => "Lane",
                    'phone' => "+1 2074698494",
                    'adress' => "2839 Victioria Court",
                    'postcode' => "ME 04416",
                    'city' => "Bucksport"
                ]
            ],
            [
                'username' => "Alis1963",
                'email' => "FrankCClark@jourrapide.com",
                'password' => "strongpassword",
                'deliveryInformation' => [
                    'first_name' => "Frank",
                    'last_name' => "Clark",
                    'phone' => "+1 3365453789",
                    'adress' => "2788 Keyser Ridge Road",
                    'postcode' => "NC 27455",
                    'city' => "Greensboro"
                ]
            ],
            [
                'username' => "Rombeli",
                'email' => "CollinLSetzer@teleworm.us",
                'password' => "strongpassword",
                'deliveryInformation' => [
                    'first_name' => "Collin",
                    'last_name' => "Setzer",
                    'phone' => "+1 3864271153",
                    'adress' => "4541 Willis Avenue",
                    'postcode' => "FL 32069",
                    'city' => "New Smyrna Beach"
                ]
            ],
            [
                'username' => "Suposed",
                'email' => "AndrewCAllen@teleworm.us",
                'password' => "strongpassword",
                'deliveryInformation' => [
                    'first_name' => "Andrew",
                    'last_name' => "Allen",
                    'phone' => "+1 4252676757",
                    'adress' => "4829 Ryder Avenue",
                    'postcode' => "WA 98204",
                    'city' => "Everett"
                ]
            ],
            [
                'username' => "Anday1967",
                'email' => "EdithBPatterson@teleworm.us",
                'password' => "strongpassword",
                'deliveryInformation' => [
                    'first_name' => "Edith",
                    'last_name' => "Patterson",
                    'phone' => "+1 7573435543",
                    'adress' => "1451 Pinchelone Street",
                    'postcode' => "VA 23502",
                    'city' => "Norfolk"
                ]
            ],
            [
                'username' => "Thereas",
                'email' => "DanielLCaffey@jourrapide.com",
                'password' => "strongpassword",
                'deliveryInformation' => [
                    'first_name' => "Daniel",
                    'last_name' => "Caffey",
                    'phone' => "+1 5102198681",
                    'adress' => "3712 Wayside Lane",
                    'postcode' => "CA 94520",
                    'city' => "Concord"
                ]
            ],
            [
                'username' => "Venswithe",
                'email' => "LucilleMKurland@dayrep.com",
                'password' => "strongpassword",
                'deliveryInformation' => [
                    'first_name' => "Lucille",
                    'last_name' => "Kurland",
                    'phone' => "+1 4044429831",
                    'adress' => "3944 Clement Street",
                    'postcode' => "GA 30305",
                    'city' => "Atlanta"
                ]
            ],
            [
                'username' => "Carch1997",
                'email' => "StacyABlackburn@armyspy.com",
                'password' => "strongpassword",
                'deliveryInformation' => [
                    'first_name' => "Stacy",
                    'last_name' => "Blackburn",
                    'phone' => "+1 3217953948",
                    'adress' => "543 Rosemont Avenue",
                    'postcode' => "FL 32810",
                    'city' => "Orlando"
                ]
            ],
        ];


        $userManager = $this->container->get('fos_user.user_manager');

        foreach ($users as $key => $userdata)
        {
            $user = $userManager->createUser();
            $user->setEnabled(true);

            $user->setUsername($userdata['username']);
            $user->setEmail($userdata['email']);
            $user->setPlainPassword($userdata['password']);

            $deliveryInformation = $this->createDeliveryInformation($userdata['deliveryInformation'], $userdata['email']);

            $user->setDeliveryInformation($deliveryInformation);

            if (isset($userdata['role']))
            {
                $user->setRoles($userdata['role']);
            }

            $userManager->updateUser($user, true);

            $this->addReference('user'.$key, $user);
        }

    }

    private function createDeliveryInformation(array $informationData, string $email)
    {
        $deliveryInformation = new DeliveryInformation();
        $deliveryInformation->setFirstName($informationData['first_name']);
        $deliveryInformation->setLastName($informationData['last_name']);
        $deliveryInformation->setPhone($this->createPhone($informationData['phone']));
        $deliveryInformation->setEmail($email);
        $deliveryInformation->setAdress($informationData['adress']);
        $deliveryInformation->setPostcode($informationData['postcode']);
        $deliveryInformation->setCity($informationData['city']);
        return $deliveryInformation;
    }

    private function createPhone($phoneNumber): PhoneNumber
    {
        list($country, $number) = explode(' ', $phoneNumber);
        $phone = new PhoneNumber();
        $phone->setCountryCode($country);
        $phone->setNationalNumber($number);
        return $phone;
    }

}
