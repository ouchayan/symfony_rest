<?php

// src/AppBundle/DataFixtures/ORM/LoadUserData.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
        
        $user1 = new User();
        $user1->setEmail("ouchayan.h@gmail.com");
        $user1->setDescription("administrateur");
        $user1->setEnabled(TRUE);
        $user1->setPlainPassword('123456');
        $user1->setUsername("admin");
        $user1->setRole($this->getReference('role1'));
        $manager->persist($user1);
       

        $manager->flush();
    }

    public function getOrder() {
        return 3;
    }

}
