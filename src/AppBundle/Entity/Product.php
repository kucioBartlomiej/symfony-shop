<?php

namespace AppBundle\Entity;

use AppBundle\Product\ProductDefaultPicture;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Utils\Sluggify;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use AppBundle\Validator\ProductName;

/**
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 * @ProductName(groups={"CreateProduct", "EditProduct"})
 */
class Product {

    const STATUS_LIST = [
        'On sale' => 'on-sale',
        'Suspended' => 'suspended'
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
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     *
     * @Assert\NotBlank(groups={"CreateProduct", "EditProduct"})
     * @Assert\Length(min=3, max=155, groups={"CreateProduct", "EditProduct"})
     */
    private $name;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *
     * @Assert\NotBlank(groups={"CreateProduct" , "EditProduct"})
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank(groups={"CreateProduct", "EditProduct"})
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", length=11, scale=2)
     *
     * @Assert\NotBlank(groups={"CreateProduct", "EditProduct"})
     * @Assert\Type(message="price must be a numeric value", type="numeric", groups={"CreateProduct", "EditProduct"})
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(groups={"EditProduct"})
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $slug;

    /**
     * @var Picture
     *
     * @ORM\OneToOne(targetEntity="Picture", mappedBy="product", cascade={"persist", "remove"})
     */
    private $picture;

     /**
      * @var Stock
      *
     * @ORM\OneToOne(targetEntity="Stock", mappedBy="product", cascade={"persist", "remove"})
     */
    private $stock;

    /**
     * @var UploadedFile
     *
     * @Assert\Image(maxSize = "1M" )
     */
    private $pictureFile;


    public function __construct()
    {
        $this->status = self::STATUS_LIST['Suspended'];
    }


    private function setSlug(string $name)
    {
        $this->slug = Sluggify::sluggify($name);
    }


    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string | null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Category | null
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return string | null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return float | null
     */
    public function getPrice()
    {
        return $this->price;
    }


    public function getStatus(): string
    {
        foreach (self::STATUS_LIST as $key => $value)
        {
            return ($this->status == $value) ? $key : $this->status;
        }
    }


    public function getSlug(): string
    {
        return $this->slug;
    }


    public function setName(string $name)
    {
        $this->name = $name;
        $this->setSlug($name);
    }


    public function setCategory(Category $category)
    {
        $this->category = $category;
    }


    public function setDescription(string $description)
    {
        $this->description = $description;
    }


    public function setPrice(float $price)
    {
        $this->price = $price;
    }


    public function setStatus(string $status)
    {
        $this->status = $status;
    }


    public function getStock(): Stock
    {
        return $this->stock;
    }


    public function setStock(Stock $stock) {
        $this->stock = $stock;
    }

    /**
     * @return Picture | null
     */
    public function getPicture()
    {
        return $this->picture;
    }


    public function setPicture(Picture $picture) {
        $this->picture = $picture;
    }

    /**
     * @return UploadedFile | null
     */
    public function getPictureFile()
    {
        return $this->pictureFile;
    }


    public function setPictureFile(UploadedFile $pictureFile) {
        $this->pictureFile = $pictureFile;
    }


    public function getImage(): string
    {
        return ($this->picture) ? $this->picture->getFullPath() : ProductDefaultPicture::defaultImage();
    }

}
