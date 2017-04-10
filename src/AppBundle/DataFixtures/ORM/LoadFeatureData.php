<?php

// src/AppBundle/DataFixtures/ORM/LoadUserData.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Feature;

class LoadFeatureData extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        $feature1 = new Feature();
        $feature1->setCode('manage_user');
        $feature1->setDescription('Manage users');
        $manager->persist($feature1);

        $this->addReference('feature1', $feature1);

        $feature2 = new Feature();
        $feature2->setCode('manage_role');
        $feature2->setDescription('Manage roles');
        $manager->persist($feature2);
        
        $this->addReference('feature2', $feature2);

        $feature3 = new Feature();
        $feature3->setCode('manage_feature');
        $feature3->setDescription('Manage features');
        $manager->persist($feature3);
        
        $this->addReference('feature3', $feature3);

        $manager->flush();
    }

    public function getOrder() {
        return 1;
    }

}
