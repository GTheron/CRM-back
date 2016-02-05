<?php

namespace Core\RestBundle\Model;

/**
 * @author Gabriel Theron <gabriel@class-web.fr>
 * @copyright Class-Web
 */
interface ResourceInterface
{
    /**
     * @return string
     */
    public function getUid();

    /**
     * Fournit une liste d'événement correspondant à la ressource.
     * Si ils correspondent aux événements de CoreRestBundle (voir Core/RestBundle/CoreRestEvents),
     * ils seront lancés par ResourceManager.
     * Ces événements pourront être écoutés par des listeners.
     *
     * @return array
     */
    public function getEvents();

    public static function getEntityName();

}