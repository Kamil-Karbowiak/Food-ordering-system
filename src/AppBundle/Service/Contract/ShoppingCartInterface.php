<?php
/**
 * Created by PhpStorm.
 * User: Kamil
 * Date: 2017-12-11
 * Time: 13:21
 */

namespace AppBundle\Service\Contract;


use AppBundle\Entity\OrderItem;

interface ShoppingCartInterface
{
    public function add(OrderItem $orderItem);
    public function remove($id);
    public function has($id);
    public function itemsCount();
    public function all();
    public function getSubTotal();
}