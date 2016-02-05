<?php

namespace Core\UserBundle\Security;

use Core\RestBundle\Service\ResourceManagerInterface;
use Core\UserBundle\Model\RoleBearerInterface;
use Core\UserBundle\Model\UserInterface;
use Core\UserBundle\Security\AuthorizationManagerInterface;
use Symfony\Component\Security\Acl\Dbal\AclProvider;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Model\AclInterface;
use Symfony\Component\Security\Acl\Model\EntryInterface;
use Symfony\Component\Security\Acl\Model\SecurityIdentityInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class SecurityManager
 *
 * @author Gabriel Théron <gabriel@class-web.fr>
 * @copyright Class Web 2015
 * @package Core\RestBundle\Service
 */
class AuthorizationManager implements AuthorizationManagerInterface
{
    /**
     * @var ResourceManagerInterface
     */
    protected $rm;

    /**
     * @var AccessDecisionManagerInterface
     */
    protected $decisionManager;

    public function __construct(
        ResourceManagerInterface $rm,
        AccessDecisionManagerInterface $decisionManager
    )
    {
        $this->rm = $rm;
        $this->decisionManager = $decisionManager;
    }

    /* Roles */

    /**
     * {@inheritDoc}
     */
    public function grantRole($role, RoleBearerInterface $subject)
    {
        $subject->addRole($role);
        return $subject;
    }

    /**
     * {@inheritDoc}
     */
    public function revokeRole($role, RoleBearerInterface $subject)
    {
        $subject->removeRole($role);
        return $subject;
    }

    /**
     * {@inheritDoc}
     */
    public function isGrantedRoles(array $roles, UserInterface $user)
    {
        $token = new UsernamePasswordToken($user, 'none', 'none', $user->getRoles());
        return $this->decisionManager->decide($token, $roles);
    }

    /**
     * {@inheritDoc}
     */
    public function isGrantedRole($role, UserInterface $user)
    {
        return $this->isGrantedRoles(array($role), $user);
    }
}