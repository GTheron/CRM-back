<?php

/*
* This file is part of the CRM-back package.
*
* (c) Gabriel Théron <gabriel.theron90@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace App\CrmBundle\Controller;

use App\CrmBundle\Entity\Customer;
use Core\RestBundle\Controller\ResourceController;
use Core\RestBundle\Model\Resource;
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
 * CustomerController
 *
 * @package AppBundle\Controller;
 * @author Gabriel Théron <gabriel.theron90@gmail.com>
 *  
*/
class CustomerController extends ResourceController implements ClassResourceInterface
{
    /**
     * @return AbstractResourceManager
     */
    protected function getResourceManager()
    {
        return $this->get('core_rest.resource_manager');
    }


    /**
     * Trouve et affiche un client
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Trouve et affiche un client"
     * )
     *
     * @Rest\Get("/customers/{uid}")
     * @ParamConverter("customer", class="AppCrmBundle:Customer")
     *
     * @param Customer $customer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction(Customer $customer)
    {
        return $this->handleView($this->view($customer, 200));
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Crée un nouveau client",
     *  parameters={
     *      {"name"="firstName", "dataType"="string", "required"=true, "description"="first name"},
     *      {"name"="lastName", "dataType"="string", "required"=true, "description"="last name"},
     *      {"name"="metAt", "dataType"="datetime", "required"=true, "description"="met at"},
     *      {"name"="status", "dataType"="string", "required"=true, "description"="status"}
     *  }
     * )
     *
     * @Rest\Post("/customers")
     * @ParamConverter("customer", class="AppCrmBundle:Customer", converter="core_rest.param_converter.resource")
     *
     * @param Customer $customer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postAction(Customer $customer, Request $request)
    {
        $customer->setDeleted(false);
        $this->getResourceManager()->create($customer);

        return $this->handleView($this->view($customer, 201));
    }
}