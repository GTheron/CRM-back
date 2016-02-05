<?php

namespace Core\RestBundle\Service;

use Core\RestBundle\Model\ResourceInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Cette interface définit le comportement des services qui manipuleront les entités.
 *
 * @author Gabriel Theron <gabriel@class-web.fr>
 * @copyright Class-Web
 */
interface ResourceManagerInterface
{
    /**
     * Valide une resource
     *
     * @param ResourceInterface $resource
     * @return ResourceInterface|ConstraintViolationList
     */
    public function validate(ResourceInterface $resource);

    /**
     * Crée une ressource
     *
     * @param ResourceInterface $resource
     * @param bool|true $flush
     * @return mixed
     */
    public function create(ResourceInterface $resource, $flush = true);

    /**
     * Met à jour une ressource existante
     *
     * @param ResourceInterface $resource
     * @param bool|true $flush
     * @return mixed
     */
    public function update(ResourceInterface $resource, $flush = true);

    /**
     * Supprime une ressource
     *
     * @param ResourceInterface $resource
     * @param bool|true $flush
     * @return mixed
     */
    public function delete(ResourceInterface $resource, $flush = true);

    /**
     * Met à jour la ressource
     *
     * @param ResourceInterface $resource
     * @param bool $flush
     * @return mixed
     */
    public function save(ResourceInterface $resource, $flush = true);

    /**
     * Par exemple, pour Acme\DemoBundle\Entity\Post ou AcmeDemoBundle\Entity\Post,
     * le retour sera: AcmeDemoBundle:Post
     *
     * @param $class
     * @return string
     */
    public function getShortClass($class);

    /**
     * Par exemple, pour AcmeDemoBundle:Post,
     * le retour sera: Acme\DemoBundle\Entity\Post
     *
     * @param $shortClass
     * @return string
     */
    public function getFullClass($shortClass);

    /**
     * Retourne le repository d'une resource
     *
     * @param ResourceInterface $resource
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository(ResourceInterface $resource);

    /**
     * Retourne le manager associé au service
     *
     * @return ObjectManager
     */
    public function getManager();

    /**
     * Retourne le nom d'une resource.
     * Par exemple, pour Core\RestBundle\Entity\Resource,
     * retourne Resource
     *
     * @param $class
     * @return mixed
     */
    public function getResourceName($class);

    /**
     * Lance un événement pour une ressource.
     * Si la resource possède un nom d'événement "spécifique", lance aussi cet événement.
     *
     * @param $eventName
     * @param ResourceInterface $resource
     */
    public function fireEvent($eventName, ResourceInterface $resource);
}