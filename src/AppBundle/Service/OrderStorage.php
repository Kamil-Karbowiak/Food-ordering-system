<?php
namespace AppBundle\Service;

use AppBundle\Service\Contract\OrderStorageInterface;

class OrderStorage implements OrderStorageInterface
{
    private $ordersContainer;

    public function __construct($ordersContainer = 'order_items')
    {
        $this->ordersContainer = $ordersContainer;
    }

    public function set($index, $value)
    {
        $_SESSION[$this->ordersContainer][$index] = $value;
    }

    public function get($index)
    {
        return $this->has($index) ? $_SESSION[$this->ordersContainer][$index] : null;
    }

    public function has($index)
    {
        return isset($_SESSION[$this->ordersContainer][$index]) ? true : false;
    }

    public function remove($index)
    {
        if($this->has($index)){
            unset($_SESSION[$this->ordersContainer][$index]);
        }
    }

    public function clear()
    {
        unset($_SESSION[$this->ordersContainer]);
    }

    public function all(){
        return empty($_SESSION[$this->ordersContainer]) ? [] : $_SESSION[$this->ordersContainer];
    }

    public function itemsCount(){
        return isset($_SESSION[$this->ordersContainer]) ? count($_SESSION[$this->ordersContainer]) : 0;
    }
}