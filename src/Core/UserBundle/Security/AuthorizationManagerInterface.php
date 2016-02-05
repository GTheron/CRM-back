<?php

namespace Core\UserBundle\Security;

use Core\UserBundle\Model\RoleBearerInterface;
use Core\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Acl\Model\SecurityIdentityInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class AuthorizationManagerInterface
 *
 * @author Gabriel Théron <gabriel@class-web.fr>
 * @copyright Class Web 2015
 * @package Core\UserBundle\Security
 */
interface AuthorizationManagerInterface
{
    /**
     * Donne un role à un sujet
     *
     * @param $role
     * @param RoleBearerInterface $subject
     */
    public function grantRole($role, RoleBearerInterface $subject);

    /**
     * Retire un role à un sujet
     *
     * @param $role
     * @param RoleBearerInterface $subject
     * @return mixed
     */
    public function revokeRole($role, RoleBearerInterface $subject);

    /**
     * Vérifie que l'utilisateur a un ensemble de roles
     *
     * @param array $roles
     * @param UserInterface $user
     * @return bool
     * @throws \Symfony\Component\Security\Acl\Exception\InvalidDomainObjectException
     */
    public function isGrantedRoles(array $roles, UserInterface $user);

    /**
     * Vérifie que l'utilisateur a un rôle
     *
     * @param $role
     * @param UserInterface $user
     * @return mixed
     */
    public function isGrantedRole($role, UserInterface $user);
}