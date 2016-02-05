<?php

namespace Core\UserBundle\EventListener;

use Core\RestBundle\CoreRestEvents;
use Core\RestBundle\Event\ResourceEvent;
use Core\RestBundle\Model\ResourceInterface;
use Core\RestBundle\Service\ResourceManagerInterface;
use Core\UserBundle\Security\AuthorizationManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class ResourceRoleListener
 *
 * @author Gabriel Théron <gabriel@class-web.fr>
 * @copyright Class Web 2015
 * @package Core\UserBundle\EventListener
 */
class ResourceRoleListener implements EventSubscriberInterface
{
    /**
     * @var ResourceManagerInterface
     */
    private $rm;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    public function __construct(
        ResourceManagerInterface $rm,
        AuthorizationCheckerInterface $authorizationChecker
    )
    {
        $this->rm = $rm;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            CoreRestEvents::RESOURCE_CHECK_CREATE => 'checkCreate',
            CoreRestEvents::RESOURCE_CHECK_UPDATE => 'checkUpdate',
            CoreRestEvents::RESOURCE_CHECK_DELETE => 'checkDelete',
            CoreRestEvents::RESOURCE_CHECK_VIEW => 'checkView'
        );
    }

    public function checkCreate(ResourceEvent $event)
    {
        //$this->checkRole('CREATE', $event);
    }

    public function checkUpdate(ResourceEvent $event)
    {
        //$this->checkRole('UPDATE', $event);
    }

    public function checkDelete(ResourceEvent $event)
    {
        //$this->checkRole('DELETE', $event);
    }

    private function checkRole($roleSuffix, ResourceEvent $event)
    {
        $resource = $event->getResource();
        $resourceName = $this->rm->getResourceName(get_class($resource));
        $roleName = 'ROLE_'.strtoupper($resourceName).'_'.$roleSuffix;

        $isGranted = $this->authorizationChecker->isGranted($roleName);

        if(!$isGranted)
            throw new AccessDeniedHttpException('User does not have role '.$roleName);
    }
}