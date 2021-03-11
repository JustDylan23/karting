<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user->setVoorletters('T');
        $user->setTussenvoegsel('van der');
        $user->setAchternaam('Hout');

        $user->setUsername('test_user');
        $user->setEmail('test_user@mail.com');
        $user->setPassword($this->userPasswordEncoder->encodePassword($user, 'test_user'));

        $user->setTelefoon('06 1234 5678');
        $user->setAdres('Straatnaam 01');
        $user->setWoonplaats('Woonplaats');
        $user->setPostcode('1234AB');

        $manager->persist($user);
        $manager->flush();


        $user = new User();

        $user->setVoorletters('T');
        $user->setTussenvoegsel('van der');
        $user->setAchternaam('Hout');

        $user->setUsername('test_admin');
        $user->setEmail('test_admin@mail.com');
        $user->setPassword($this->userPasswordEncoder->encodePassword($user, 'test_admin'));
        $user->setRoles(['ROLE_ADMIN']);

        $user->setTelefoon('06 1234 5678');
        $user->setAdres('Straatnaam 01');
        $user->setWoonplaats('Woonplaats');
        $user->setPostcode('1234AB');

        $manager->persist($user);
        $manager->flush();

        $manager->flush();
    }
}
