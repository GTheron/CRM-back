<?php

namespace Core\UserBundle\Service;
use Core\UserBundle\Model\UserInterface;

/**
 * Class UserManagerInterface
 *
 * @author Gabriel Théron <gabriel@class-web.fr>
 * @copyright Class Web 2015
 * @package Core\UserBundle\Service
 */
interface UserManagerInterface
{
    /**
     * Met à jour les champs de l'utilisateur
     *
     * @param UserInterface $user
     */
    public function updateUser(UserInterface $user);

    /**
     * Met à jour les champs canoniques de l'utilisateur
     *
     * @param UserInterface $user
     * @return mixed
     */
    public function updateCanonicalFields(UserInterface $user);

    /**
     * Met à jour le mot de passe de l'utilisateur
     *
     * @param UserInterface $user
     * @return mixed
     */
    public function updatePassword(UserInterface $user);

    /**
     * Canonicalise une chaîne
     *
     * @param $string
     * @return mixed
     */
    public function canonicalize($string);
}