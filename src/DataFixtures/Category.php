<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Category extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $categories = [
            'Business',
            'Computing',
            'Tech',
            'Engineering',
        ];

        $i = 1;
        foreach ($categories as $category) {
            $cat = new \App\Entity\Category();
            $cat->setTitle($category);

            $manager->persist($cat);

            $this->addReference('category' . $i++, $cat);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
