<?php

namespace Core\UserBundle\Controller;

use Core\RestBundle\Controller\ResourceController;
use Core\RestBundle\Service\AbstractResourceManager;
use Core\UserBundle\Entity\Group;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class GroupController
 *
 * @author Gabriel Théron <gabriel@class-web.fr>
 * @copyright Class Web 2015
 * @package Core\UserBundle\Controller
 */
class GroupController extends ResourceController implements ClassResourceInterface
{
    /**
     * @return AbstractResourceManager
     */
    protected function getResourceManager()
    {
        return $this->get('core_rest.resource_manager');
    }

    /**
     * Liste les groupes
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Liste les groupes"
     * )
     */
    public function cgetAction()
    {
        $groups = $this->getResourceManager()->getRepository(new Group())->findBy(array("feature" => false));

        return $this->handleView($this->view($groups, 200));
    }

    /**
     * Trouve un groupe
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Trouve un groupe"
     * )
     *
     * @Rest\Get("/groups/{uid}")
     * @ParamConverter("group", class="CoreUserBundle:Group")
     *
     * @param Group $group
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction(Group $group)
    {
        return $this->handleView($this->view($group, 200));
    }
}