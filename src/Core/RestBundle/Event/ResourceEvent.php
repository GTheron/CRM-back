<?php

namespace Core\RestBundle\Event;

use Core\RestBundle\Model\ResourceInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Gabriel Theron <gabriel@class-web.fr>
 * @copyright Class-Web
 */
class ResourceEvent extends Event
{
    /**
     * @var ResourceInterface
     */
    public $resource;

    public function __construct(ResourceInterface $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @return ResourceInterface
     */
    public function getResource()
    {
        return $this->resource;
    }

}