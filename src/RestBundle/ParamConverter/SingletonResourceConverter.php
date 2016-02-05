<?php

namespace Core\RestBundle\ParamConverter;

use Core\RestBundle\Repository\SingletonRepositoryInterface;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SingletonResourceConverter
 *
 * @author Gabriel Théron <gabriel@class-web.fr>
 * @copyright Class Web 2015
 * @package Core\RestBundle\ParamConverter
 */
class SingletonResourceConverter extends ResourceConverter
{
    protected function findOneBy($class, Request $request, $options)
    {
        $em = $this->rm->getManager();

        try {
            $repository = $em->getRepository($class);

            if (!$repository instanceof SingletonRepositoryInterface)
                return;

            $singleton = $repository->findSingleton();

            //throw new \Exception(get_class($singleton));

            return $singleton;
        } catch (NoResultException $e) {
            return;
        }
    }
}