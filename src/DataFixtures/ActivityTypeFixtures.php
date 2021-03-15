<?php

namespace App\DataFixtures;

use App\Entity\ActivityType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActivityTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $activityType = new ActivityType();
        $activityType
            ->setName('Vrije training')
            ->setMinAge(12)
            ->setDuration(15)
            ->setPrice(15)
        ;
        $manager->persist($activityType);

        $activityType = new ActivityType();
        $activityType
            ->setName('Grand Prix')
            ->setMinAge(12)
            ->setDuration(15)
            ->setPrice(50)
        ;
        $manager->persist($activityType);

        $activityType = new ActivityType();
        $activityType
            ->setName('Endurance race')
            ->setMinAge(16)
            ->setDuration(15)
            ->setPrice(65)
        ;
        $manager->persist($activityType);

        $activityType = new ActivityType();
        $activityType
            ->setName('Kinder race')
            ->setMinAge(8)
            ->setDuration(15)
            ->setPrice(18)
        ;
        $manager->persist($activityType);

        $manager->flush();
    }
}
