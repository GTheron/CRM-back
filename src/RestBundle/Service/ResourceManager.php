<?php

namespace Core\RestBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use  Core\RestBundle\Model\ResourceInterface;

/**
 * @author Gabriel Theron <gabriel@class-web.fr>
 * @copyright Class-Web
 */
class ResourceManager extends AbstractResourceManager
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var RecursiveValidator
     */
    private $validator;



    public function __construct(EntityManager $em, EventDispatcherInterface $dispatcher, RecursiveValidator $validator)
    {
        $this->em = $em;
        $this->dispatcher = $dispatcher;
        $this->validator = $validator;
    }

    /**
     * @return EntityManager
     */
    public function getManager()
    {
        return $this->em;
    }

    /**
     * @return EventDispatcherInterface
     */
    protected function getEventDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * @return RecursiveValidator
     */
    protected function getValidator()
    {
        return $this->validator;
    }
}