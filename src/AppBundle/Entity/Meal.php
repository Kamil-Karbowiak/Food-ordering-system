<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Meal
 *
 * @ORM\Table(name="meal")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MealRepository")
 */
class Meal
{
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=64, scale=2)
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string $image
     * @Assert\File( maxSize = "1024k", mimeTypesMessage = "Please upload a valid Image")
     */
    private $image2;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="meals", fetch="EAGER", cascade={"persist"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="Restaurant", inversedBy="meals", fetch="EAGER", cascade={"persist"})
     * @ORM\JoinColumn(name="restaurant_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $restaurant;

    /**
     * @ORM\OneToMany(targetEntity="MealOption", mappedBy="meal", cascade={"persist"}, fetch="EAGER")
     */
    private $mealOptions;

    /**
     * @ORM\Column(name="quantity", type="integer")
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     */
    private $quantity;

    /**
     * Meal constructor.
     */
    public function __construct()
    {
       $this->mealOptions = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
    /**
     * @return mixed
     */
    public function getMealOptions()
    {
        return $this->mealOptions->getValues();
    }

    /**
     * @param mixed $mealOptions
     */
    public function setMealOptions($mealOptions)
    {
        $this->mealOptions = $mealOptions;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return mixed
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }

    /**
     * @param mixed $restaurant
     */
    public function setRestaurant($restaurant)
    {
        $this->restaurant = $restaurant;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Meal
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Meal
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Meal
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Meal
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }


    /**
     * @return mixed
     */
    public function getImage2()
    {
        return $this->image2;
    }

    /**
     * @param mixed $image2
     */
    public function setImage2($image2)
    {
        $this->image2 = $image2;
    }

    public function isMealNotAvailable(){
        return (int)$this->quantity < 1 ? true : false;
    }

    public function isMealLowAvailable(){
        return (int)$this->quantity < 20 && (int)$this->quantity > 0 ? true : false;
    }
}

