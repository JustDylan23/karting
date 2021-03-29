<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public const USER_REFERENCE = 'test_user';
    public const ADMIN_REFERENCE = 'test_admin';

    private UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setInitials('T');
        $user->setLastName('User');

        $user->setUsername('test_user');
        $user->setEmail('test_user@mail.com');
        $user->setPassword($this->userPasswordEncoder->encodePassword($user, 'test_user'));
        $user->setRoles(['ROLE_USER']);

        $user->setPhoneNumber('06 1234 5678');
        $user->setAddress('Straatnaam 01');
        $user->setCity('Woonplaats');
        $user->setPostalCode('1234AB');

        $this->setReference(self::USER_REFERENCE, $user);
        $manager->persist($user);

        $user = new User();
        $user->setInitials('T2');
        $user->setLastName('User2');

        $user->setUsername('test_user2');
        $user->setEmail('test_use2r@mail.com');
        $user->setPassword($this->userPasswordEncoder->encodePassword($user, 'test_user2'));
        $user->setRoles(['ROLE_USER']);

        $user->setPhoneNumber('06 1234 5678');
        $user->setAddress('Straatnaam 01');
        $user->setCity('Woonplaats');
        $user->setPostalCode('1234AB');

        $this->setReference(self::USER_REFERENCE, $user);
        $manager->persist($user);

        $user = new User();
        $user->setInitials('T');
        $user->setLastName('Admin');

        $user->setUsername('test_admin');
        $user->setEmail('test_admin@mail.com');
        $user->setPassword($this->userPasswordEncoder->encodePassword($user, 'test_admin'));
        $user->setRoles(['ROLE_SUPER_ADMIN']);

        $user->setPhoneNumber('06 1234 5678');
        $user->setAddress('Straatnaam 01');
        $user->setCity('Woonplaats');
        $user->setPostalCode('1234AB');

        $this->setReference(self::ADMIN_REFERENCE, $user);

        $manager->persist($user);
        $manager->flush();

        $manager->flush();
    }
}
