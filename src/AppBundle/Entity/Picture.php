<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use AppBundle\Utils\RandomString;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="pictures")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PictureRepository")
 * @UniqueEntity(fields={"name"})
 */

class Picture {

    const PATH_TO_IMAGE = 'uploads/products/';

    /**
     * @var int
     * 
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=150)
     */
    private $path;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=120)
     */
    private $name;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=10)
     */
    private $extension;
    
    /**
     * @var int
     * 
     * @ORM\Column(type="string")
     */
    private $fullPath;
    
     /**
     * @var Product
     * 
     * @ORM\OneToOne(targetEntity="Product", inversedBy="picture")
     */
    private $product;
    
    /**
     *
     * @var UploadedFile
     */
    private $file;

    public function __construct()
    {
        $this->path = self::PATH_TO_IMAGE;
    }


    public function getId(): int
    {
        return $this->id;
    }


    public function getPath(): string
    {
        return $this->path;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function getExtension(): string
    {
        return $this->extension;
    }


    public function getProduct(): Product
    {
        return $this->product;
    }


    public function getFullPath(): string
    {
        return $this->fullPath;
    }


    public function getFile(): UploadedFile
    {
        return $this->file;
    }


    public function getNameWithExtension(): string
    {
        return $this->name.".".$this->extension;
    }


    public function setPath(string $path) {
        $this->path = $path;
    }


    public function setName(string $name) {
        $this->name = $name;
    }


    public function setExtension(string $extension) {
        $this->extension = $extension;
    }


    public function setFullPath(string $fullPath) {
        $this->fullPath = $fullPath;
    }


    public function setProduct(Product $product) {
        $this->product = $product;
    }


    public function createFromProduct(Product $product)
    {
        $this->file = $product->getPictureFile();
        $this->product = $product;
        $this->name = RandomString::generate();
        $this->extension = $this->file->guessExtension();
        $this->fullPath = $this->path.$this->name.".".$this->extension;
    }

}
