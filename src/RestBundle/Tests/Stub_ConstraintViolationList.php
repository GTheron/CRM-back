<?php

namespace Core\RestBundle\Tests;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Gabriel Theron <gabriel@class-web.fr>
 * @copyright Class-Web
 */


class Stub_ConstraintViolationList implements \IteratorAggregate, ConstraintViolationListInterface
{
    private $count;

    public function __construct($count = 0)
    {
        $this->count = $count;
    }

    public function add(ConstraintViolationInterface $violation)
    {
    }

    public function addAll(ConstraintViolationListInterface $otherList)
    {
    }

    public function get($offset)
    {
    }

    public function has($offset)
    {
    }

    public function set($offset, ConstraintViolationInterface $violation)
    {
    }

    public function remove($offset)
    {
    }

    public function offsetExists($offset)
    {
    }

    public function offsetGet($offset)
    {
    }

    public function offsetSet($offset, $value)
    {
    }

    public function offsetUnset($offset)
    {
    }

    public function count()
    {
        return $this->count;
    }

    public function getIterator()
    {
    }

    public function current()
    {
    }

    public function next()
    {
    }

    public function key()
    {
    }

    public function valid()
    {
    }

    public function rewind()
    {
    }
}
