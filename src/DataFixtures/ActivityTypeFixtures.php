<?php

namespace App\DataFixtures;

use App\Entity\ActivityType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActivityTypeFixtures extends Fixture
{
    public const ACTIVITY_1 = 'activity-1';
    public const ACTIVITY_2 = 'activity-2';
    public const ACTIVITY_3 = 'activity-3';
    public const ACTIVITY_4 = 'activity-4';
    public const ACTIVITY_5 = 'activity-5';
    public const ACTIVITY_6 = 'activity-6';

    public function load(ObjectManager $manager): void
    {
        $activityType = new ActivityType();
        $activityType
            ->setName('Vrije training')
            ->setMinAge(12)
            ->setDuration(15)
            ->setPrice(15)
        ;
        $this->setReference(self::ACTIVITY_1, $activityType);
        $manager->persist($activityType);

        $activityType = new ActivityType();
        $activityType
            ->setName('Grand Prix')
            ->setMinAge(12)
            ->setDuration(15)
            ->setPrice(50)
        ;
        $this->setReference(self::ACTIVITY_2, $activityType);
        $manager->persist($activityType);

        $activityType = new ActivityType();
        $activityType
            ->setName('Endurance race')
            ->setMinAge(16)
            ->setDuration(15)
            ->setPrice(65)
        ;
        $this->setReference(self::ACTIVITY_3, $activityType);
        $manager->persist($activityType);

        $activityType = new ActivityType();
        $activityType
            ->setName('Kinder race')
            ->setMinAge(8)
            ->setDuration(15)
            ->setPrice(18)
        ;
        $this->setReference(self::ACTIVITY_4, $activityType);
        $manager->persist($activityType);

        $activityType = new ActivityType();
        $activityType
            ->setName('Senioren race')
            ->setDescription('Zo veel mogelijk rondjes rijden')
            ->setMinAge(45)
            ->setDuration(30)
            ->setPrice(15.5)
        ;
        $this->setReference(self::ACTIVITY_5, $activityType);
        $manager->persist($activityType);

        $activityType = new ActivityType();
        $activityType
            ->setName('Duo race')
            ->setDescription('Deelnemers worden aan elkaar gekoppeld. De langzaamste deelnemer bepaald de positie op de scorelijst')
            ->setMinAge(16)
            ->setDuration(45)
            ->setPrice(20)
        ;
        $this->setReference(self::ACTIVITY_6, $activityType);
        $manager->persist($activityType);

        $manager->flush();
    }
}
