<?php

/*
* This file is part of the CRM-back package.
*
* (c) Gabriel Théron <gabriel.theron90@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace App\CrmBundle\Entity;

use Core\RestBundle\Model\RichResource;

/**
 * Customer
 *
 * @package AppBundle\Entity;
 * @author Gabriel Théron <gabriel.theron90@gmail.com>
 *  
*/
class Customer extends RichResource
{
    const CUSTOMER_STATE_PROSPECT = 'customer.state.prospect';

    const CUSTOMER_STATE_CUSTOMER = 'customer.state.customer';

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var \DateTime
     */
    private $metAt;

    /**
     * @var string
     */
    private $status;

    public function __construct()
    {
        parent::__construct();
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
     * @return \DateTime
     */
    public function getMetAt()
    {
        return $this->metAt;
    }

    /**
     * @param \DateTime $metAt
     */
    public function setMetAt($metAt)
    {
        $this->metAt = $metAt;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}