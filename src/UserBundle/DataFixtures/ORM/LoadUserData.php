<?php

namespace Core\UserBundle\DataFixtures\ORM;

use Core\RestBundle\DataFixtures\AbstractContainerAwareFixture;
use Core\UserBundle\Entity\Notification;
use Core\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadUserData
 *
 * @author Gabriel Théron <gabriel@class-web.fr>
 * @copyright Class Web 2015
 * @package Core\UserBundle\DataFixtures\ORM
 */
class LoadUserData extends AbstractContainerAwareFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $rm = $this->container->get('core_rest.resource_manager');

        //On récupère les groupes "utilisateurs"
        $adminGroup = $this->getReference('admin-group');
        $individualGroup = $this->getReference('individual-group');
        $agencyGroup = $this->getReference('agency-group');
        $builderGroup = $this->getReference('builder-group');
        $developerGroup = $this->getReference('developer-group');
        $instigatorGroup = $this->getReference('instigator-group');

        //On crée des nouveaux utilisateurs

        $userAdmin = new User();
        $userAdmin->setEmail('admin@ad.min');
        $userAdmin->setFirstName("Michel");
        $userAdmin->setLastName("Admin");

        $userAdmin->setPlainPassword('admin');

        $particulier = new User();
        $particulier->setEmail('particulier@exemple.com');
        $particulier->setFirstName("Josette");
        $particulier->setLastName("Salle");
        $particulier->setPlainPassword("particulier");

        //On affecte les groupes aux utilisateurs
        $userAdmin->addGroup($adminGroup);
        $particulier->addGroup($individualGroup);

        //UserBundle
        $userAdmin->addRole('ROLE_NOTIFICATION_DELETE');
        $userAdmin->addRole('ROLE_NOTIFICATION_UPDATE');
        $userAdmin->setChildrenCount(2);
        $userAdmin->setChildren(array("age"=>15),0);
        $userAdmin->setChildren(array("age"=>12),1);

        $rm->create($userAdmin);

        $this->addReference('userAdmin',$userAdmin);
    }

    public function getReferenceRepository()
    {
        return $this->referenceRepository;
    }
    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}
