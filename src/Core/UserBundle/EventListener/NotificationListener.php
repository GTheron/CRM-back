<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 06/01/16
 * Time: 15:28
 */


namespace Core\UserBundle\EventListener;

use Asi\ProBundle\Entity\ContactDemand;
use Core\CustomerBundle\Repository\ProfessionalRepository;
use Core\RestBundle\CoreRestEvents;
use Core\RestBundle\Event\ResourceEvent;
use Core\RestBundle\Model\ResourceInterface;
use Core\RestBundle\Service\ResourceManagerInterface;
use Core\UserBundle\Entity\Notification;
use Core\UserBundle\Security\AuthorizationManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Core\UserBundle\Entity\User;

/**
 * Class NotificationListener
 * @package Core\UserBundle\EventListener
 */
class NotificationListener implements EventSubscriberInterface
{
    /**
     * @var ResourceManagerInterface
     */
    private $rm;

    public function __construct(ResourceManagerInterface $rm)
    {
        $this->rm = $rm;

    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            User::USER_CREATED => 'userCreated'
        );
    }

    public function userCreated(ResourceEvent $event)
    {
        $rep = $this->rm->getRepository(new User());
        $admin = $rep->findOneByEmail('admin@ad.min');

        $notif = new Notification();
        $notif->setUser($admin);
        $notif->setText("Un nouvel utilisateur s'est inscrit");
        $notif->setType($event->getName());
        $notif->setDatas(array($event->getResource()));

        $this->rm->create($notif);
    }

    public function sendAllGroup ($pro, $event, $text)
    {
        $rep = $this->rm->getRepository(new User());
        //Recupérer les utilisateurs de pro en fonction de l'id du groupe
        $users = $rep->findAll();

        foreach ($users as $user)
        {
            if($user->getProfessional() == $pro)
            {
                $notif = new Notification();
                $notif->setUser($user);
                $notif->setText($text);
                $notif->setType($event->getName());
                $notif->setDatas(array($event->getResource()));
                $this->rm->create($notif);
            }
        }
    }
}