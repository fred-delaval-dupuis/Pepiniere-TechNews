<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class User extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $users = [
            ['Hugo', 'LIEGEARD', 'wf3@hl-media.fr', 'test', '2018-06-26 14:33:08', null, ['ROLE_USER']],
            ['PEREZ', 'Sylviane', 'sylviane.perez@wf3.fr', 'test', '2018-06-26 14:33:08', null, ['ROLE_USER']],
            ['Delaval-Dupuis', 'Frédéric', 'test@test.xyz', 'test', '2018-06-26 14:33:08', null, ['ROLE_AUTHOR']]
        ];

        $i = 1;
        foreach ($users as $user) {
            $u = new \App\Entity\User();
            $u->setLastName($user[0]);
            $u->setFirstName($user[1]);
            $u->setEmail($user[2]);
            $u->setPassword($user[3]);
            $u->setRoles($user[6]);
            $u->setUsername($user[1]);
            $u->setSalt(null);

            $manager->persist($u);

            $this->addReference('user' . $i++, $u);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
