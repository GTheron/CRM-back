<?php

namespace Core\UserBundle\Model;

use Core\RestBundle\Model\ResourceInterface;

/**
 * Class GroupInterface
 *
 * @author Gabriel Théron <gabriel@class-web.fr>
 * @copyright Class Web 2015
 * @package Core\UserBundle\Model
 */
interface GroupInterface extends ResourceInterface, RoleBearerInterface
{
    /**
     * @param string $role
     *
     * @return self
     */
    public function addRole($role);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name);
}