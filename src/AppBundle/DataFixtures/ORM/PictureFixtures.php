<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Utils\RandomString;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Picture;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PictureFixtures extends Fixture implements OrderedFixtureInterface {

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getOrder(): int {
        return 6;
    }

    public function load(ObjectManager $manager) {
        
        
        for ($index = 1; $index < 50; $index++)
        {

            $name = RandomString::generate().$index;

            $picture  = new Picture();
            $picture->setProduct($this->getReference('product'.$index));
            $picture->setName($name.'.png');
            $picture->setExtension('png');
            $picture->setFullPath('uploads/products/'.$name.'.png');
            
            $manager->persist($picture);

            $this->generatePictureFile($name);
        }
        
        $manager->flush();
    }

    private function generatePictureFile($pictureName)
    {
        $kernelDir = $this->container->getParameter('kernel.root_dir');
        $picturesDir = $kernelDir.'/../web/uploads/products';
        $startPic = $kernelDir.'/../web/uploads/toCopy.png';

        copy($startPic, $picturesDir.'/'.$pictureName.'.png');

    }

}
