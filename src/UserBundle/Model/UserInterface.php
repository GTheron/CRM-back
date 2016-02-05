<?php

namespace Core\UserBundle\Model;

use Core\RestBundle\Model\ResourceInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Class UserInterface
 *
 * @author Gabriel Théron <gabriel@class-web.fr>
 * @copyright Class Web 2015
 * @package Core\UserBundle\Model
 */
interface UserInterface extends AdvancedUserInterface, ResourceInterface, RoleBearerInterface
{
    /**
     * Gets email.
     *
     * @return string
     */
    public function getEmail();

    /**
     * Sets the email.
     *
     * @param string $email
     *
     * @return self
     */
    public function setEmail($email);

    /**
     * Gets the canonical email in search and sort queries.
     *
     * @return string
     */
    public function getEmailCanonical();

    /**
     * Sets the canonical email.
     *
     * @param string $emailCanonical
     *
     * @return self
     */
    public function setEmailCanonical($emailCanonical);

    /**
     * Gets the plain password.
     *
     * @return string
     */
    public function getPlainPassword();

    /**
     * Sets the plain password.
     *
     * @param string $password
     *
     * @return self
     */
    public function setPlainPassword($password);

    /**
     * Sets the hashed password.
     *
     * @param string $password
     *
     * @return self
     */
    public function setPassword($password);

    /**
     * @param boolean $boolean
     *
     * @return self
     */
    public function setEnabled($boolean);

    /**
     * Sets the locking status of the user.
     *
     * @param boolean $boolean
     *
     * @return self
     */
    public function setLocked($boolean);

    /**
     * Gets the confirmation token.
     *
     * @return string
     */
    public function getConfirmationToken();

    /**
     * Sets the confirmation token
     *
     * @param string $confirmationToken
     *
     * @return self
     */
    public function setConfirmationToken($confirmationToken);

    /**
     * Sets the timestamp that the user requested a password reset.
     *
     * @param null|\DateTime $date
     *
     * @return self
     */
    public function setPasswordRequestedAt(\DateTime $date = null);

    /**
     * Checks whether the password reset request has expired.
     *
     * @param integer $ttl Requests older than this many seconds will be considered expired
     *
     * @return boolean true if the user's password request is non expired, false otherwise
     */
    public function isPasswordRequestNonExpired($ttl);

    /**
     * Sets the last login time
     *
     * @param \DateTime $time
     *
     * @return self
     */
    public function setLastLogin(\DateTime $time = null);

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @return int
     */
    public function getPhone();
}