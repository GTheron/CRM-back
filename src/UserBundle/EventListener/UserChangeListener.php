<?php

namespace Core\UserBundle\EventListener;

use Core\AdminBundle\Entity\Email;
use Core\RestBundle\Event\ResourceEvent;
use Core\UserBundle\Entity\User;
use Core\UserBundle\Event\EventAssociatedWithUser;
use Core\UserBundle\Model\UserInterface;
use Core\UserBundle\Service\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class UserChangeListener
 *
 * @author Gabriel Théron <gabriel@class-web.fr>
 * @copyright Class Web 2015
 * @package Core\UserBundle\EventListener
 */
class UserChangeListener implements EventSubscriberInterface
{
    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @var
     */
    protected $mailer;

    public function __construct(UserManagerInterface $userManager, $mailer)
    {
        $this->userManager = $userManager;
        $this->mailer = $mailer;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            User::BEFORE_USER_VALIDATION => 'updateUser',
            User::BEFORE_USER_DELETED => 'deleteAccount',
            User::USER_CREATED => 'userCreated',
            User::USER_REQUESTED_NEW_PASSWORD => 'userRequestedNewPassword'
        );
    }

    public function userCreated(ResourceEvent $event)
    {

        $resource = $event->getResource();
        $resource->addRole('ROLE_USER');
        $this->userManager->updateUser($resource);
    }

    public function updateUser(ResourceEvent $event)
    {
        $resource = $event->getResource();
        if(!$resource instanceof UserInterface)
            throw new \Exception('Invalid resource type (expected User, got '.get_class($resource));
        //TODO créer une exception particulière pour le cas d'invalidité



        $this->userManager->updateUser($resource);
    }
    public function deleteAccount(ResourceEvent $event)
    {
        $resource = $event->getResource();
        if(!$resource instanceof UserInterface)
            throw new \Exception('Invalid resource type (expected User, got '.get_class($resource));
        $resource->setEnabled(0);
        $resource->setLocked(1);
        $this->userManager->updateUser($resource);
    }

    public function userRequestedNewPassword(EventAssociatedWithUser $event)
    {
        $resource = $event->getResource();
        $user = $event->getUser();

        $parameters = array(
            'name' => $user->getFirstName() . ' ' . $user->getLastName(),
            'link' => '<a href="'.$resource.'">Réinitialiser mon mot de passe</a>',
        );

        $this->mailer->sendEmail(Email::TYPE_PASSWORDRESET, 'fr', $user->getEmail(), $parameters);
    }
}