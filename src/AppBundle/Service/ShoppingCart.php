<?php
namespace AppBundle\Service;

use AppBundle\Entity\OrderItem;
use AppBundle\Service\Contract\ShoppingCartInterface;
use Doctrine\ORM\EntityManager;

class ShoppingCart implements ShoppingCartInterface
{
    private $ordersStorage;
    private $em;

    public function __construct(OrderStorage $orderStorage, EntityManager $em = null)
    {
        $this->em = $em;
        $this->ordersStorage = $orderStorage;
    }

    public function add(OrderItem $orderItem)
    {
        $meal     = $orderItem->getMeal();
        $stock    = $meal->getQuantity();
        $quantity = $orderItem->getQuantity();
        if($quantity > $stock){
            throw new \Exception('This quantity is not available on the stock');
        }
        $this->em->detach($orderItem);
        $this->ordersStorage->set($orderItem->getHash(), $orderItem);
        $meal->setQuantity($stock-$quantity);
        $this->em->flush($meal);
    }

    public function remove($hashId)
    {
        if($this->has($hashId)) {
            $orderItem = $this->ordersStorage->get($hashId);
            $meal = $this->em->merge($orderItem->getMeal());
            $stock = $meal->getQuantity();
            $quantity = $orderItem->getQuantity();
            $meal->setQuantity($stock + $quantity);
            $this->em->flush();
            $this->ordersStorage->remove($hashId);
        }
    }

    public function has($id)
    {
        return $this->ordersStorage->has($id);
    }

    public function all()
    {
        $items = [];
        foreach ($this->ordersStorage->all() as $item) {
            $options = $item->getSelectedOptions();
            $meal = $item->getMeal();

            $mergeItem = $this->em->merge($item);
            foreach ($options as $option){
                $mergeItem->addSelectedOption($this->em->merge($option));
            }
            $mergeItem->setMeal($this->em->merge($meal));
            $items[] = $mergeItem;
        }
        return $items;
    }

    public function itemsCount()
    {
        return $this->ordersStorage->itemsCount();
    }

    public function clear()
    {
        $this->ordersStorage->clear();
    }

    public function getSubTotal()
    {
        $total = 0;
        foreach ($this->ordersStorage->all() as $item){
            $total += $item->getAmount();
        }
        return $total;
    }
}