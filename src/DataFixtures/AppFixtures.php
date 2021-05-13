<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $password = '123';
        $user = new User();
        $user->setEmail('user@user.com')
        ->setFullname('Test User')
        ->setRoles('ROLE_USER');
        // $password = $this->encoder->encodePassword($user, '123');
        $user->setPassword($password);
        $manager->persist($user);

        $user2 = new User();
        $user2->setEmail('admin@admin.com')
        ->setFullname('Admin Admin')
        ->setRoles('RILE_ADMIN');
        // $password = $this->encoder->encodePassword($user2, '123');
        $user2->setPassword($password);
        $manager->persist($user2);

        $manager->flush();
    }
}
