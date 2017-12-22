<?php
/**
 * Created by PhpStorm.
 * User: Kamil
 * Date: 2017-11-16
 * Time: 22:24
 */

namespace AppBundle\Service\Contract;


interface OrderStorageInterface
{
    public function set($index, $value);
    public function get($index);
    public function has($index);
    public function remove($index);
    public function clear();

}