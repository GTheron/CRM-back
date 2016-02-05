<?php

namespace Core\RestBundle\DataFixtures;

use Core\RestBundle\Service\ResourceManagerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Created by PhpStorm.
 * User: Class-Web
 * Date: 31/12/2015
 * Time: 11:06
 */
abstract class AbstractContainerAwareFixture extends AbstractFixture implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return ResourceManagerInterface
     */
    protected function getResourceManager()
    {
        return $this->container->get('core_rest.resource_manager');
    }
}