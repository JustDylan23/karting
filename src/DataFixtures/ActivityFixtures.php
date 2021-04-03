<?php

namespace App\DataFixtures;

use App\Entity\Activity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ActivityFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $activity = new Activity();
        $activity
            ->setMaxRegistrations(6)
            ->setActivityType($this->getReference(ActivityTypeFixtures::ACTIVITY_1))
            ->setDatetime(new \DateTime())
        ;
        $manager->persist($activity);

        $activity = new Activity();
        $activity
            ->setMaxRegistrations(10)
            ->setActivityType($this->getReference(ActivityTypeFixtures::ACTIVITY_2))
            ->setDatetime(new \DateTime('+1 min'))
        ;
        $manager->persist($activity);

        $activity = new Activity();
        $activity
            ->setMaxRegistrations(8)
            ->setActivityType($this->getReference(ActivityTypeFixtures::ACTIVITY_3))
            ->setDatetime(new \DateTime('+2 mins'))
        ;
        $manager->persist($activity);

        $activity = new Activity();
        $activity
            ->setMaxRegistrations(10)
            ->setActivityType($this->getReference(ActivityTypeFixtures::ACTIVITY_4))
            ->setDatetime(new \DateTime('+3 mins'))
        ;
        $manager->persist($activity);

        $activity = new Activity();
        $activity
            ->setMaxRegistrations(6)
            ->setActivityType($this->getReference(ActivityTypeFixtures::ACTIVITY_5))
            ->setDatetime(new \DateTime('+4 mins'))
        ;
        $manager->persist($activity);

        $activity = new Activity();
        $activity
            ->setMaxRegistrations(2)
            ->setActivityType($this->getReference(ActivityTypeFixtures::ACTIVITY_6))
            ->setDatetime(new \DateTime('+5 mins'))
        ;
        $manager->persist($activity);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ActivityTypeFixtures::class, UserFixtures::class];
    }
}
