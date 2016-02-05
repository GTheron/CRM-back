<?php

namespace Core\UserBundle\Controller;

use Core\RestBundle\Controller\ResourceController;
use Core\RestBundle\Service\AbstractResourceManager;
use Core\UserBundle\Entity\Group;
use Core\UserBundle\Entity\User;
use Core\UserBundle\Form\UserType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 *
 * @author Gabriel Théron <gabriel@class-web.fr>
 * @copyright Class Web 2015
 * @package Core\UserBundle\Controller
 */
class UserController extends ResourceController implements ClassResourceInterface
{
    /**
     * @return AbstractResourceManager
     */
    protected function getResourceManager()
    {
        return $this->get('core_rest.resource_manager');
    }

    /**
     * Trouve et affiche un utilisateur
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Trouve et affiche un utilisateur"
     * )
     *
     * @Rest\Get("/users/{uid}")
     * @ParamConverter("user", class="CoreUserBundle:User")
     *
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction(User $user)
    {
        return $this->handleView($this->view($user, 200));
    }

    /**
     * Trouve l'utilisateur courant
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Trouve l'utilisateur courant"
     * )
     *
     * @Rest\Get("/currentUsers/{wat}")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCurrentUserAction($wat)
    {
        return $this->handleView($this->view($this->getUser(), 200));
    }

    /**
     * Trouve tous les particuliers
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Trouve tous les particuliers"
     * )
     *
     * @Rest\Get("/individuals")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getIndividualsAction()
    {
        $rm = $this->getResourceManager();
        $repository = $rm->getRepository(new User());

        $users = $repository->findAllByGroupName(Group::NAME_INDIVIDUALS);

        return $this->handleView($this->view($users));
    }
}