<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session;

class Cart implements CartInterface
{
    private $session;
    private $bucket;

    public function __construct(Session $session, $bucket = 'cart')
    {
        $this->session = $session;
        $this->bucket = $bucket;
    }

    public function set($index, $value)
    {
        $this->session->set([$this->bucket, $index], $value);
    }

    public function get($index)
    {
        return $this->exists($index) ? $this->session->get([$this->bucket, $index]) : null;
    }

    public function exists($index)
    {
        return $this->session->has([$this->bucket, $index]);
    }

    public function all()
    {
        return $this->session->get($this->bucket);
    }

    public function remove($index)
    {
        $this->session->clear([$this->bucket, $index]);
    }
}