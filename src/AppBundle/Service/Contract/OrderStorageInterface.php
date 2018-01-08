<?php
namespace AppBundle\Service\Contract;


interface OrderStorageInterface
{
    public function set($index, $value);
    public function get($index);
    public function has($index);
    public function remove($index);
    public function clear();

}