<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="meal_option")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MealOptionRepository")
 */
class MealOption
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
     * @ORM\ManyToOne(targetEntity="Meal", inversedBy="mealOptions", cascade={"persist"})
     * @Assert\NotBlank()
     */
    private $meal;

    /**
     *
     * @ORM\OneToMany(targetEntity="Option", mappedBy="mealOption", cascade={"persist"})
     * @Assert\NotBlank()
     */
    private $options;

    /**
     * MenuOptions constructor.
     */
    public function __construct()
    {
        $this->options = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    public function getOptionsCount(){
        return $this->options->count();
    }

    public function setOptions(array $options){
        $this->options = $options;
    }

    public function addOption(Option $option)
    {
       $option->setMealOption($this);
       $this->options->add($option);
    }

    public function removeOption(Option $option){
        $this->options->removeElement($option);
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
     * @return MealOption
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
     * Set meal
     *
     * @param integer $meal
     *
     * @return MealOption
     */
    public function setMeal($meal)
    {
        $this->meal = $meal;

        return $this;
    }

    /**
     * Get meal
     *
     * @return int
     */
    public function getMeal()
    {
        return $this->meal;
    }
}

