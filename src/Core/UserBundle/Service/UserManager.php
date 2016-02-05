<?php

namespace Core\UserBundle\Service;

use Core\RestBundle\Service\ResourceManagerInterface;
use Core\UserBundle\Entity\User;
use Core\UserBundle\Event\EventAssociatedWithUser;
use Core\UserBundle\Model\UserInterface;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Class UserManager
 *
 * @author Gabriel Théron <gabriel@class-web.fr>
 * @copyright Class Web 2015
 * @package Core\UserBundle\Service
 */
class UserManager implements UserManagerInterface
{
    /**
     * @var ResourceManagerInterface
     */
    private $rm;

    /**
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

    protected $router;

    protected $host;

    protected $eventDispatcher;

    public function __construct(ResourceManagerInterface $rm, EncoderFactoryInterface $encoderFactory,$router,$host,$eventDispatcher)
    {
        $this->rm = $rm;
        $this->encoderFactory = $encoderFactory;
        $this->router = $router;
        $this->host = $host;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Met à jour les champs de l'utilisateur
     *
     * @param UserInterface $user
     */
    public function updateUser(UserInterface $user)
    {
        $this->updateCanonicalFields($user);
        $this->updatePassword($user);
    }

    /**
     * Met à jour les champs canoniques de l'utilisateur
     *
     * @param UserInterface $user
     * @return mixed
     */
    public function updateCanonicalFields(UserInterface $user)
    {
        $user->setEmailCanonical($this->canonicalize($user->getEmail()));
    }

    /**
     * Met à jour le mot de passe de l'utilisateur
     *
     * @param UserInterface $user
     * @return mixed
     */
    public function updatePassword(UserInterface $user)
    {
        if (0 !== strlen($password = $user->getPlainPassword())) {
            $encoder = $this->getEncoder($user);
            $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
            $user->eraseCredentials();
        }
    }

    /**
     * Canonicalise une chaîne
     *
     * @param $string
     * @return mixed
     */
    public function canonicalize($string)
    {
        return null === $string ? null : mb_convert_case($string, MB_CASE_LOWER, mb_detect_encoding($string));
    }

    /**
     * @param UserInterface $user
     * @return mixed
     */
    protected function getEncoder(UserInterface $user)
    {
        return $this->encoderFactory->getEncoder($user);
    }


    public function resetPassword(UserInterface $user)
    {

        if ($user->isPasswordRequestNonExpired(86400) == false)
        {

            $user->setConfirmationToken(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));

            $url = $this->host.$this->router->generate('asi_individual_password_is_reset', array(
                    'token' => $user->getConfirmationToken()
                ));



            $today = new \DateTime();
            $today->format('Y-m-d H:i:s');
            $user->setPasswordRequestedAt($today);
            $this->rm->update($user);

            $event=New EventAssociatedWithUser($url,$user,null);
            $this->eventDispatcher->dispatch(User::USER_REQUESTED_NEW_PASSWORD,$event);


            return true;
        }
        return false;
    }
}