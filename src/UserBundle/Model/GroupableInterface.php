<?php

namespace Core\UserBundle\Model;

/**
 * Class GroupableInterface
 *
 * @author Gabriel Théron <gabriel@class-web.fr>
 * @copyright Class Web 2015
 * @package Core\UserBundle\Model
 */
interface GroupableInterface
{
    /**
     * Retourne la liste des groupes de l'utilisateur
     *
     * @return array
     */
    public function getGroups();

    /**
     * Ajoute un groupe à l'utilisateur
     *
     * @param GroupInterface $group
     * @return mixed
     */
    public function addGroup(GroupInterface $group);

    /**
     * Enlève un groupe à l'utilisateur
     *
     * @param GroupInterface $group
     * @return mixed
     */
    public function removeGroup(GroupInterface $group);

    /**
     * Retourne true si l'utilisateur a le groupe
     *
     * @param GroupInterface $group
     * @return bool
     */
    public function hasGroup(GroupInterface $group);
}