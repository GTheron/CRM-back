<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 12/01/16
 * Time: 14:43
 */
namespace Core\UserBundle\Event;


use Core\RestBundle\Event\ResourceEvent;
use Core\RestBundle\Model\ResourceInterface;
use Core\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;


class EventAssociatedWithUser extends ResourceEvent
{
    /**
     * @var
     */
    protected $user;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    public function __construct( $resource,UserInterface $user=null,Request $request=null)
    {
        $this->resource = $resource;
        $this->user=$user;
        $this->request=$request;
    }

    /**
     * @return ResourceInterface
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest()
    {
        return $this->request;
    }



}