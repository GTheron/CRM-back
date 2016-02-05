<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 06/01/16
 * Time: 10:18
 */

namespace Core\UserBundle\Controller;


use Core\RestBundle\Controller\ResourceController;
use Core\RestBundle\CoreRestEvents;
use Core\RestBundle\Service\AbstractResourceManager;
use Core\UserBundle\Entity\Notification;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;


class NotificationController extends ResourceController implements ClassResourceInterface
{
    /**
     * @return AbstractResourceManager
     */
    protected function getResourceManager()
    {
        return $this->get('core_rest.resource_manager');
    }

    /**
     * Liste les notifications
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Liste les notifications"
     * )
     * @Rest\GET("/notifications")
     */
    public function cgetAction()
    {
        $user = $this->getUser();

        $rm = $this->getDoctrine()->getRepository('CoreUserBundle:Notification');
        $notifications = $rm->findBy(array('user' => $user));

        return $this->handleView($this->view($notifications, 200));
    }

    /**
     * "Notification vue, automatiquement updaté dans le backoffice"
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Notification vue, automatiquement updaté dans le backoffice "
     * )
     *
     * @ParamConverter("notification", class="CoreUserBundle:Notification")
     * @Rest\Put("/notifications/{uid}")
     *
     * @param Notification $notification
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putAction(Notification $notification)
    {
        $notification->setSeen(true);

        $this->getResourceManager()->fireEvent(CoreRestEvents::RESOURCE_CHECK_UPDATE, $notification);
        $this->getResourceManager()->update($notification);

        return $this->handleView($this->view($notification));
    }
}
