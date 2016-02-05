<?php

namespace Core\RestBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modèle de ressource riche agnostique en termes de stockage
 *
 * @author Gabriel Theron <gabriel@class-web.fr>
 * @copyright Class-Web
 */
abstract class RichResource extends Resource implements RichResourceInterface
{
    /**
     * @var bool
     */
    protected $deleted;

    /**
     * @var \DateTime
     */
    protected $deletedAt;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->deleted = false;
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     * @return bool
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param \DateTime $deletedAt
     * @return mixed|void
     */
    public function setDeletedAt(\DateTime $deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function updateTimestamps()
    {
        if(is_null($this->createdAt))
            $this->createdAt = new \DateTime();
        else
            $this->updatedAt = new \DateTime();
    }
}