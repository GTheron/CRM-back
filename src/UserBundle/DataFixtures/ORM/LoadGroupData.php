<?php

namespace Core\UserBundle\DataFixtures\ORM;

use Core\RestBundle\DataFixtures\AbstractContainerAwareFixture;
use Core\UserBundle\Entity\Group;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadGroupData
 *
 * @author Gabriel Théron <gabriel@class-web.fr>
 * @copyright Class Web 2015
 * @package Core\UserBundle\DataFixtures\ORM
 */
class LoadGroupData extends AbstractContainerAwareFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}