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
            ->setActivityType($this->getReference(ActivityTypeFixtures::ACTIVITY_1))
            ->setDatetime(new \DateTime())
        ;
        $manager->persist($activity);

        $activity = new Activity();
        $activity
            ->setActivityType($this->getReference(ActivityTypeFixtures::ACTIVITY_2))
            ->setDatetime(new \DateTime())
        ;
        $manager->persist($activity);

        $activity = new Activity();
        $activity
            ->setActivityType($this->getReference(ActivityTypeFixtures::ACTIVITY_3))
            ->setDatetime(new \DateTime())
        ;
        $manager->persist($activity);

        $activity = new Activity();
        $activity
            ->setActivityType($this->getReference(ActivityTypeFixtures::ACTIVITY_4))
            ->setDatetime(new \DateTime())
        ;
        $manager->persist($activity);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ActivityTypeFixtures::class, UserFixtures::class];
    }
}
