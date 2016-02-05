<?php

namespace Core\UserBundle\Entity;

use Core\RestBundle\Model\RichResource;
use Core\UserBundle\Model\GroupableInterface;
use Core\UserBundle\Model\GroupInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Group
 *
 * @author Gabriel Théron <gabriel@class-web.fr>
 * @copyright Class Web 2015
 * @package Core\UserBundle\Entity
 */
class Group extends RichResource implements GroupInterface, GroupableInterface
{
    const NAME_INDIVIDUALS = "group.name.individuals";

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $feature;

    /**
     * @var array
     */
    private $roles;

    /**
     * @var ArrayCollection
     */
    private $groups;

    public function __construct()
    {
        $this->roles = array();
        $this->groups = new ArrayCollection();
        $this->feature = false;

        parent::__construct();
    }

    /**
     * @param string $role
     *
     * @return self
     */
    public function addRole($role)
    {
        if(!$this->hasRole($role))
            $this->roles[] = $role;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return boolean
     */
    public function isFeature()
    {
        return $this->feature;
    }

    /**
     * @param boolean $feature
     */
    public function setFeature($feature)
    {
        $this->feature = $feature;
    }

    /**
     * @param string $role
     *
     * @return boolean
     */
    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->getRoles());
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        $roles = $this->roles;
        $groups = $this->getGroups();
        foreach($groups as $group)
            $roles = array_merge($roles, $group->getRoles());
        return $roles;
    }

    /**
     * @param string $role
     *
     * @return self
     */
    public function removeRole($role)
    {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }

        return $this;
    }

    /**
     * @param array $roles
     *
     * @return self
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * Retourne la liste des groupes de l'utilisateur
     *
     * @return array
     */
    public function getGroups()
    {
        $groups = $this->groups->toArray();
        foreach($groups as $group)
            $groups = array_merge($groups, $group->getGroups());

        return $groups;
    }

    /**
     * Ajoute un groupe à l'utilisateur
     *
     * @param GroupInterface $group
     * @return mixed
     */
    public function addGroup(GroupInterface $group)
    {
        if(!$this->hasGroup($group))
            $this->groups->add($group);
    }

    /**
     * Enlève un groupe à l'utilisateur
     *
     * @param GroupInterface $group
     * @return mixed
     */
    public function removeGroup(GroupInterface $group)
    {
        if($this->hasGroup($group))
            $this->groups->removeElement($group);
    }

    /**
     * Retourne true si l'utilisateur a le groupe
     *
     * @param GroupInterface $group
     * @return bool
     */
    public function hasGroup(GroupInterface $group)
    {
        return $this->groups->contains($group);
    }
}