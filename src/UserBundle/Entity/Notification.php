<?php

namespace Core\UserBundle\Entity;

use Core\RestBundle\Model\RichResource;

/**
 * Notification
 */
class Notification extends RichResource
{
    /**
     * @var array
     */
    protected $datas;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var bool
     */
    protected $seen;

    /**
     * @var \Core\UserBundle\Entity\User
     */
    protected $user;

    public function __construct()
    {
        $this->seen = false;
        parent::__construct();
    }

    /**
     * Set data
     *
     * @param array $datas
     *
     * @return Notification
     */
    public function setDatas($datas)
    {
        $this->datas = $datas;

        return $this;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getDatas()
    {
        return $this->datas;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Notification
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Notification
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param boolean $seen
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;
    }

    /**
     * @return boolean
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * @param \Core\UserBundle\Entity\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return \Core\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}

