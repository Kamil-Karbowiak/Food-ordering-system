<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="order_item")
 * @ORM\Entity()
 */

class OrderItem
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
     * @ORM\Column(name="hash", type="string")
     */
    private $hash;
    /**
     * @ORM\ManyToOne(targetEntity="Meal", cascade={"detach"})
     * @ORM\JoinColumn(name="meal_id", referencedColumnName="id")
     */
    private $meal;

    /**
     * @ORM\Column(name="amount", type="decimal")
     */
    private $amount;

    /**
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToMany(targetEntity="Option", fetch="EAGER")
     * @ORM\JoinTable(name="orderitems_options",
     *     joinColumns={@ORM\JoinColumn(name="order_item_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="option_id", referencedColumnName="id",
     *      )})
     */
    private $selectedOptions;

    /**
     * OrderItem constructor.
     * @param Meal $meal
     */
    public function __construct(Meal $meal)
    {
        $this->hash = uniqid();
        $this->meal = $meal;
        $this->selectedOptions = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param mixed $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getMeal()
    {
        return $this->meal;
    }

    /**
     * @param mixed $meal
     * @return $this
     */
    public function setMeal(Meal $meal)
    {
        $this->meal = $meal;
        $this->refreshAmount();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        $this->refreshAmount();
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
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
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        $this->refreshAmount();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSelectedOptions()
    {
        return $this->selectedOptions;
    }

    public function setSelectedOptions($options)
    {
        $this->selectedOptions = $options;
    }

    /**
     * @param mixed $selectedOption
     */
    public function addSelectedOption(Option $selectedOption)
    {
        if (!$this->selectedOptions->contains($selectedOption)) {
            $this->selectedOptions->add($selectedOption);
            $this->refreshAmount();
        }
    }

    public function refreshAmount()
    {
        $amount = $this->quantity * $this->meal->getPrice();
        foreach ($this->selectedOptions as $option){
            $amount += $option->getPrice() * $this->quantity;
        }
        $this->amount = $amount;
        return $amount;
    }
}