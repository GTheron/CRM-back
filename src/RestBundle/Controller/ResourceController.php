<?php

namespace Core\RestBundle\Controller;

use Core\RestBundle\Service\AbstractResourceManager;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * @author Gabriel Theron <gabriel@class-web.fr>
 * @copyright Class-Web
 */
abstract class ResourceController extends FOSRestController
{
    /**
     * @return AbstractResourceManager
     */
    abstract protected function getResourceManager();
}