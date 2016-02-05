<?php

namespace Core\UserBundle\Entity;

use Asi\AdvertBundle\Entity\Advert;
use Asi\AdvertBundle\Entity\Rental;
use Asi\AdvertBundle\Entity\Transaction;
use Asi\ProBundle\Entity\Agency;
use Asi\ProBundle\Entity\Builder;
use Asi\ProBundle\Entity\Developer;
use Asi\ProBundle\Entity\Instigator;
use Core\CustomerBundle\Entity\Professional;
use Core\RestBundle\CoreRestEvents;
use Core\RestBundle\Model\RichResource;
use Core\UserBundle\Model\GroupableInterface;
use Core\UserBundle\Model\GroupInterface;
use Core\UserBundle\Model\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Role\Role;

/**
 * User
 */
class User extends \Core\UserBundle\Model\User
{
    /**
     * Événement lancé quand un user est créé
     */
    const USER_CREATED = 'core_user.user.created';

    /**
     * Événement lancé quand un user est mis à jour
     */
    const USER_UPDATED = 'core_user.user.updated';

    /**
     * Événement lancé quand un user est sauvegardé
     */
    const USER_SAVED = 'core_user.user.saved';

    /**
     * Événement lancé avant la validation d'un utilisateur
     */
    const BEFORE_USER_VALIDATION = 'core_user.user.before_validation';

    /**
     * Événement lancé avant la validation d'un utilisateur
     */
    const USER_REQUESTED_NEW_PASSWORD = 'core_user.user.requested_new_password';

    /**
     * Événement lancé avant la suppression d'un utilisateur
     */
    const BEFORE_USER_DELETED = 'core_user.user.before_deleted';

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $emailCanonical;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var string
     */
    protected $nationality;

    /**
     * @var string
     */
    protected $roleLabel;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var string
     */
    protected $plainPassword;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $salt;

    /**
     * @var bool
     */
    protected $enabled;

    /**
     * @var bool
     */
    protected $locked;

    /**
     * @var bool
     */
    protected $expired;

    /**
     * @var bool
     */
    protected $credentialsExpired;

    /**
     * @var string
     */
    protected $confirmationToken;

    /**
     * @var \DateTime
     */
    protected $passwordRequestedAt;

    /**
     * @var \DateTime
     */
    protected $lastLogin;

    /**
     * @var string
     */
    protected $gender;

    /**
     * @var array
     */
    protected $roles;

    /**
     * @var array
     */
    protected $groups;

    /**
     * @var boolean
     */
    protected $phoneValidated = false;

    /**
     * @var string
     */
    protected $phoneCode;

    /**
     * @var \DateTime
     */
    protected $phoneRequestAt;

    public function __construct()
    {
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->enabled = true;
        $this->locked = false;
        $this->expired = false;
        $this->roles = array();
        $this->credentialsExpired = false;
        $this->groups = new ArrayCollection();
        $this->locale = 'fr';
        $this->gender = 'm';

        parent::__construct();
    }

    /**
     * @return array
     */
    public function getEvents()
    {
        return array_merge(parent::getEvents(),
            array(
                CoreRestEvents::RESOURCE_CREATED => User::USER_CREATED,
                CoreRestEvents::RESOURCE_UPDATED => User::USER_UPDATED,
                CoreRestEvents::RESOURCE_SAVED => User::USER_SAVED,
                CoreRestEvents::BEFORE_RESOURCE_VALIDATION => User::BEFORE_USER_VALIDATION,
                CoreRestEvents::RESOURCE_WILL_DELETE => User::BEFORE_USER_DELETED
            )
        );
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Gets the canonical email in search and sort queries.
     *
     * @return string
     */
    public function getEmailCanonical()
    {
        return $this->emailCanonical;
    }

    /**
     * Sets the canonical email.
     *
     * @param string $emailCanonical
     *
     * @return self
     */
    public function setEmailCanonical($emailCanonical)
    {
        $this->emailCanonical = $emailCanonical;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return int
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param int $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @param string $nationality
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;
    }

    /**
     * @return string
     */
    public function getRoleLabel()
    {
        return $this->roleLabel;
    }

    /**
     * @param string $roleLabel
     */
    public function setRoleLabel($roleLabel)
    {
        $this->roleLabel = $roleLabel;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Gets the plain password.
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Sets the plain password.
     *
     * @param string $password
     *
     * @return self
     */
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    /**
     * Sets the hashed password.
     *
     * @param string $password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param boolean $boolean
     *
     * @return self
     */
    public function setEnabled($boolean)
    {
        $this->enabled = $boolean;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Sets the locking status of the user.
     *
     * @param boolean $boolean
     *
     * @return self
     */
    public function setLocked($boolean)
    {
        $this->locked = $boolean;
    }

    /**
     * Gets the confirmation token.
     *
     * @return string
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * Sets the confirmation token
     *
     * @param string $confirmationToken
     *
     * @return self
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;
    }

    /**
     * Sets the timestamp that the user requested a password reset.
     *
     * @param null|\DateTime $date
     *
     * @return self
     */
    public function setPasswordRequestedAt(\DateTime $date = null)
    {
        $this->passwordRequestedAt = $date;
    }

    /**
     * @return boolean
     */
    public function isCredentialsExpired()
    {
        return $this->credentialsExpired;
    }

    /**
     * @param boolean $credentialsExpired
     */
    public function setCredentialsExpired($credentialsExpired)
    {
        $this->credentialsExpired = $credentialsExpired;
    }

    /**
     * @return boolean
     */
    public function isExpired()
    {
        return $this->expired;
    }

    /**
     * @param boolean $expired
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;
    }

    /**
     * @return bool
     */
    public function isPhoneValidated()
    {
        return $this->phoneValidated;
    }

    /**
     * @param boolean $phoneValidated
     */
    public function setPhoneValidated($phoneValidated)
    {
        $this->phoneValidated = $phoneValidated;
    }

    /**
     * @return string
     */
    public function getPhoneCode()
    {
        return $this->phoneCode;
    }

    /**
     * @param string $phoneCode
     */
    public function setPhoneCode($phoneCode)
    {
        $this->phoneCode = $phoneCode;
    }

    /**
     * @return \DateTime
     */
    protected function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }

    /**
     * Checks whether the password reset request has expired.
     *
     * @param integer $ttl Requests older than this many seconds will be considered expired
     *
     * @return boolean true if the user's password request is non expired, false otherwise
     */
    public function isPasswordRequestNonExpired($ttl)
    {
        return $this->getPasswordRequestedAt() instanceof \DateTime &&
        $this->getPasswordRequestedAt()->getTimestamp() + $ttl > time();
    }

    /**
     * Sets the last login time
     *
     * @param \DateTime $time
     *
     * @return self
     */
    public function setLastLogin(\DateTime $time = null)
    {
        $this->lastLogin = $time;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * Never use this to check if this user has access to anything!
     *
     * Use the SecurityContext, or an implementation of AccessDecisionManager
     * instead, e.g.
     *
     *         $securityContext->isGranted('ROLE_USER');
     *
     * @param string $role
     *
     * @return boolean
     */
    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->getRoles());
    }

    /**
     * Sets the roles of the user.
     *
     * This overwrites any previous roles.
     *
     * @param array $roles
     *
     * @return self
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        $roles = $this->roles;
        $groups = $this->getGroups();
        foreach ($groups as $group)
            $roles = array_merge($roles, $group->getRoles());
        return $roles;
    }

    /**
     * Adds a role to the user.
     *
     * @param string $role
     *
     * @return self
     */
    public function addRole($role)
    {
        if (!$this->hasRole($role))
            $this->roles[] = $role;
    }

    /**
     * Removes a role to the user.
     *
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
     * Retourne la liste des groupes de l'utilisateur
     *
     * @return array
     */
    public function getGroups()
    {
        $groups = $this->groups->toArray();
        foreach ($this->groups as $group)
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
        if (!$this->hasGroup($group))
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
        if ($this->hasGroup($group))
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

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return !$this->expired;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return !$this->locked;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return !$this->credentialsExpired;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize(array(
            $this->uid,
            $this->email,
            $this->password,
            $this->salt,
            $this->enabled
        ));
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list (
            $this->uid,
            $this->email,
            $this->password,
            $this->salt,
            $this->enabled
            ) = unserialize($serialized);
    }

    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @return \DateTime
     */
    public function getPhoneRequestAt()
    {
        return $this->phoneRequestAt;
    }

    /**
     * @param \DateTime $date
     */
    public function setPhoneRequestAt(\DateTime $date = null)
    {
        $this->phoneRequestAt = $date;
    }

    public function isPhoneRequestNonExpired($ttl)
    {
        return $this->getPhoneRequestAt() instanceof \DateTime &&
        $this->getPhoneRequestAt()->getTimestamp() + $ttl > time();
    }
}

