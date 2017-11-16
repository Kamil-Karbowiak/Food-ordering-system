<?php

namespace AppBundle\Service;

interface CartInterface
{
    public function set($index, $value);
    public function get($index);
    public function exists($index);
    public function all();
    public function remove($index);

}