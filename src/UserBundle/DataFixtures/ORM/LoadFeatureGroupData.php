<?php

namespace Core\UserBundle\DataFixtures\ORM;

use Core\RestBundle\DataFixtures\AbstractContainerAwareFixture;
use Core\UserBundle\Entity\Group;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadSubGroupsData
 *
 * @author Gabriel Théron <gabriel@class-web.fr>
 * @copyright Class Web 2015
 * @package Core\UserBundle\DataFixtures\ORM
 */
class LoadFeatureGroupData extends AbstractContainerAwareFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $rm = $this->getResourceManager();

        /****** Un groupe pour tous les users ******/
        $userGroup = new Group();
        $userGroup->setName('Users');
        $userGroup->setFeature(true);
        $userGroup->addRole('ROLE_USER');

        /****** Features Pros  ******/

        //AdvertManager
        $advertManagerGroup = new Group();
        $advertManagerGroup->setName("Advert Manager");
        $advertManagerGroup->setFeature(true);

        $advertManagerGroup->addRole('ROLE_FLAT_CREATE');
        $advertManagerGroup->addRole('ROLE_FLAT_UPDATE');
        $advertManagerGroup->addRole('ROLE_FLAT_DELETE');
        $advertManagerGroup->addRole('ROLE_HOUSE_CREATE');
        $advertManagerGroup->addRole('ROLE_HOUSE_UPDATE');
        $advertManagerGroup->addRole('ROLE_HOUSE_DELETE');
        $advertManagerGroup->addRole('ROLE_PROPERTY_CREATE');
        $advertManagerGroup->addRole('ROLE_PROPERTY_UPDATE');
        $advertManagerGroup->addRole('ROLE_PROPERTY_DELETE');
        $advertManagerGroup->addRole('ROLE_PROXIMITY_CREATE');
        $advertManagerGroup->addRole('ROLE_PROXIMITY_UPDATE');
        $advertManagerGroup->addRole('ROLE_PROXIMITY_DELETE');
        $advertManagerGroup->addRole('ROLE_ADDRESS_CREATE');
        $advertManagerGroup->addRole('ROLE_ADDRESS_UPDATE');
        $advertManagerGroup->addRole('ROLE_ADDRESS_DELETE');
        $advertManagerGroup->addRole('ROLE_RENTAL_CREATE');
        $advertManagerGroup->addRole('ROLE_RENTAL_UPDATE');
        $advertManagerGroup->addRole('ROLE_RENTAL_DELETE');
        $advertManagerGroup->addRole('ROLE_TRANSACTION_CREATE');
        $advertManagerGroup->addRole('ROLE_TRANSACTION_UPDATE');
        $advertManagerGroup->addRole('ROLE_TRANSACTION_DELETE');
        $advertManagerGroup->addRole('ROLE_FLATPICTURE_CREATE');

        //Commercial
        $commercialManagerGroup = new Group();
        $commercialManagerGroup->setName("Commercial Manager");
        $commercialManagerGroup->setFeature(true);
        //TODO ajouter les rôles nouveau commercial et point de vente

        //Point of sale
        $pointOfSaleManagerGroup = new Group();
        $pointOfSaleManagerGroup->setName("Point of Sale Manager");
        $pointOfSaleManagerGroup->setFeature(true);

        //Bill Monitoring
        $billMonitoringGroup = new Group();
        $billMonitoringGroup->setName("Bill Monitoring");
        $billMonitoringGroup->setFeature(true);
        //TODO ajouter les rôles suivi conso et factures

        //Prospects
        $prospectManagerGroup = new Group();
        $prospectManagerGroup->setName("Prospect Manager");
        $prospectManagerGroup->setFeature(true);
        //TODO ajouter les roles prospect

        //TAB
        $landManagerGroup = new Group();
        $landManagerGroup->setName("Land Manager");
        $landManagerGroup->setFeature(true);
        //TODO ajouter les roles TAB

        //Liste terrains
        $terrainListGroup = new Group();
        $terrainListGroup->setName("Terrain List");
        $terrainListGroup->setFeature(true);
        //TODO ajouter les roles liste terrain

        //Gestion locations
        $rentalManagerGroup = new Group();
        $rentalManagerGroup->setName("Rental Manager");
        $rentalManagerGroup->setFeature(true);
        //TODO ajouter les roles gestion locations



        /****** Features admin ******/

        //DuplicateConfig
        $duplicateConfigGroup = new Group();
        $duplicateConfigGroup->setName("Duplicate Configurator");
        $duplicateConfigGroup->setFeature(true);

        $duplicateConfigGroup->addRole('ROLE_CONFIGDUPLICATE_CREATE');
        $duplicateConfigGroup->addRole('ROLE_CONFIGDUPLICATE_UPDATE');
        $duplicateConfigGroup->addRole('ROLE_CONFIGDUPLICATE_DELETE');
        $duplicateConfigGroup->addRole('ROLE_CONFIGSCORING_UPDATE');

        //Offers & Contracts
        $contractManagerGroup = new Group();
        $contractManagerGroup->setName("Contract Manager");
        $contractManagerGroup->setFeature(true);

        $contractManagerGroup->addRole('ROLE_CONTRACT_CREATE');
        $contractManagerGroup->addRole('ROLE_CONTRACT_UPDATE');
        $contractManagerGroup->addRole('ROLE_CONTRACT_DELETE');
        $contractManagerGroup->addRole('ROLE_OFFER_CREATE');
        $contractManagerGroup->addRole('ROLE_OFFER_UPDATE');
        $contractManagerGroup->addRole('ROLE_OFFER_DELETE');

        $contractManagerGroup->addRole('ROLE_CONTACTDEMAND_DELETE');

        //Content pages & emails
        $contentManagerGroup = new Group();
        $contentManagerGroup->setName("Content Manager");
        $contentManagerGroup->setFeature(true);

        $contentManagerGroup->addRole('ROLE_EMAIL_CREATE');
        $contentManagerGroup->addRole('ROLE_EMAIL_UPDATE');
        $contentManagerGroup->addRole('ROLE_PAGE_CREATE');
        $contentManagerGroup->addRole('ROLE_PAGE_UPDATE');

        $contentManagerGroup->addRole('ROLE_CATEGORY_CREATE');
        $contentManagerGroup->addRole('ROLE_CATEGORY_UPDATE');
        $contentManagerGroup->addRole('ROLE_CATEGORY_DELETE');
        $contentManagerGroup->addRole('ROLE_ENTRY_CREATE');
        $contentManagerGroup->addRole('ROLE_ENTRY_UPDATE');
        $contentManagerGroup->addRole('ROLE_ENTRY_DELETE');

        //Pro management
        $professionalManagerGroup = new Group();
        $professionalManagerGroup->setName("Professional Manager");
        $professionalManagerGroup->setFeature(true);

        $professionalManagerGroup->addRole('ROLE_AGENCY_CREATE');
        $professionalManagerGroup->addRole('ROLE_AGENCY_UPDATE');
        $professionalManagerGroup->addRole('ROLE_AGENCY_DELETE');
        $professionalManagerGroup->addRole('ROLE_BUILDER_CREATE');
        $professionalManagerGroup->addRole('ROLE_BUILDER_UPDATE');
        $professionalManagerGroup->addRole('ROLE_BUILDER_DELETE');
        $professionalManagerGroup->addRole('ROLE_DEVELOPER_CREATE');
        $professionalManagerGroup->addRole('ROLE_DEVELOPER_UPDATE');
        $professionalManagerGroup->addRole('ROLE_DEVELOPER_DELETE');
        $professionalManagerGroup->addRole('ROLE_INSTIGATOR_CREATE');
        $professionalManagerGroup->addRole('ROLE_INSTIGATOR_UPDATE');
        $professionalManagerGroup->addRole('ROLE_INSTIGATOR_DELETE');

        $rm->create($userGroup);
        $rm->create($advertManagerGroup);
        $rm->create($duplicateConfigGroup);
        $rm->create($contractManagerGroup);
        $rm->create($contentManagerGroup);
        $rm->create($professionalManagerGroup);
        $rm->create($commercialManagerGroup);
        $rm->create($pointOfSaleManagerGroup);
        $rm->create($billMonitoringGroup);
        $rm->create($prospectManagerGroup);
        $rm->create($landManagerGroup);
        $rm->create($terrainListGroup);
        $rm->create($rentalManagerGroup);


        $this->setReference('user-group', $userGroup);
        $this->setReference('advert-manager-group', $advertManagerGroup);
        $this->setReference('duplicate-config-group', $duplicateConfigGroup);
        $this->setReference('contract-manager-group', $contractManagerGroup);
        $this->setReference('content-manager-group', $contentManagerGroup);
        $this->setReference('professional-manager-group', $professionalManagerGroup);
        $this->setReference('commercial-manager-group', $commercialManagerGroup);
        $this->setReference('point-of-sale-manager-group', $pointOfSaleManagerGroup);
        $this->setReference('bill-monitoring-group', $billMonitoringGroup);
        $this->setReference('prospect-manager-group', $prospectManagerGroup);
        $this->setReference('land-manager-group', $landManagerGroup);
        $this->setReference('terrain-list-group', $terrainListGroup);
        $this->setReference('rental-manager-group', $rentalManagerGroup);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}
