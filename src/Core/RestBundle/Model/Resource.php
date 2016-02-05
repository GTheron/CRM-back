<?php

namespace Core\RestBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modèle de ressource agnostique en termes de stockage
 *
 * @author Gabriel Theron <gabriel@class-web.fr>
 * @copyright Class-Web
 */
abstract class Resource implements ResourceInterface
{
    /**
     * Un identifiant unique pour la ressource
     *
     * @var string
     */
    protected $uid;

    /**
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    public function getEvents()
    {
        return array();
    }

    public static function getEntityName()
    {
        return get_called_class();
    }
}