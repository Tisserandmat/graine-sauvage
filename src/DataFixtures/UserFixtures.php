<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use DateTime;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();

        $date = new DateTime('now');
        $date->format('Y-m-d H:i');

        $admin->setRoles(["ROLE_ADMIN"])
            ->setEmail('grainsauvage@monsite.com')
            ->setFirstname('graine')
            ->setLastname('sauvage')
            ->setLogin('graine-sauvage')
            ->setPassword($this->passwordEncoder->encodePassword(
                $admin,
                'grainesauvage'
            ))
            ->setZipCode(45770)
            ->setDateBirth($date);

        $manager->persist($admin);
        $manager->flush();
    }
}
