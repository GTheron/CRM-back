<?php

namespace Core\RestBundle\Repository;

/**
 * Class SingletonRepositoryInterface
 *
 * @author Gabriel Théron <gabriel@class-web.fr>
 * @copyright Class Web 2015
 * @package Core\RestBundle\Repository
 */
interface SingletonRepositoryInterface
{
    /**
     * Retourne le seul élément du repository
     *
     * @return mixed
     */
    public function findSingleton();
}