<?php

namespace AppBundle\Entity;

use AppBundle\Validator\CategoryName;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Utils\Sluggify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 * @CategoryName()
 *
 */
class Category {
    
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
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(max=30)
     */
    private $name;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     */
    private $slug;
    
    /**
     * @var Category[]|Collection
     *
     * @ORM\ManyToMany(targetEntity="Category")
     * @ORM\JoinTable(name="categories_childrens",
     *      joinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="children_id", referencedColumnName="id")}
     *      )
     * })
     */
    private $categoryGroup;
    
    /**
     * @var Category
     * 
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     */
    private $parent;
    
    /**
     * @var Category[]|Collection
     * 
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     */
    private $children;
           
    /**
     * @var boolean
     * 
     * @ORM\Column(type="boolean")
     */
    private $main;    
    
    /**
     * @var Product[]|Collection
     * 
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category")
     */
    private $products;


    public function __construct(Category $parentCategory = null)
    {
        $this->parent = $parentCategory;
        $this->categoryGroup = new ArrayCollection([$this]);
        $this->main = true;
        
        if ($this->parent !== null) {
            $this->parent->addToCategoryGroup($this);
            $this->main = false;
        }
    }


    public function addToCategoryGroup(Category $parent)
    {
        $this->categoryGroup->add($parent);
        if ($this->parent !== null) {
            $this->parent->addToCategoryGroup($parent);
        }
    }
    
    /**
     * @return Category[] | Collection
     */
    public function getCategoryGroup(): Collection
    {
        return $this->categoryGroup;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }


    public function getSlug(): string
    {
       return $this->slug;
    }

    /**
     * @return Category | null
     */
    public function getParent()
    {
        return $this->parent;
    }


    public function getChildren(): Collection
    {
        return $this->children;
    }


    public function getProducts(): Collection
    {
        return $this->products;
    }


    public function setName(string $name)
    {
        $this->name = $name;
        $this->setSlug($name);
    }


    public function setSlug(string $name)
    {
        if ($this->parent === null){
            $this->slug = Sluggify::sluggify($name);
        }
        else{
            $this->slug = Sluggify::sluggify($this->parent->getSlug().'-'.$name);
        }
    }


    public function setParent(Category $parent)
    {
        $this->parent = $parent;
    }


    public function isMain(): bool
    {
        return $this->main;
    }

}
