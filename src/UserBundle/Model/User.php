<?php

namespace Core\UserBundle\Model;

use Asi\ProBundle\Entity\Agency;
use Asi\ProBundle\Entity\Builder;
use Asi\ProBundle\Entity\Developer;
use Asi\ProBundle\Entity\Instigator;
use Core\RestBundle\CoreRestEvents;
use Core\RestBundle\Model\RichResource;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class User
 *
 * @author Gabriel Théron <gabriel@class-web.fr>
 * @copyright Class Web 2015
 * @package Core\UserBundle\Model
 */
abstract class User extends RichResource implements UserInterface, GroupableInterface, \Serializable
{

}
