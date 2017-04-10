<?php

// src/AppBundle/DataFixtures/ORM/LoadUserData.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Role;

class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
        
        $role1 = new Role();
        $role1->setLibelle('Administrateur');
        $role1->addFeature($this->getReference('feature1'));
        $role1->addFeature($this->getReference('feature2'));
        $role1->addFeature($this->getReference('feature3'));

        $manager->persist($role1);
        
        $this->addReference('role1', $role1);
        
        $role2 = new Role();
        $role2->setLibelle('Manager');
        $manager->persist($role2);

        $manager->flush();
    }

    public function getOrder() {
        return 2;
    }

}
