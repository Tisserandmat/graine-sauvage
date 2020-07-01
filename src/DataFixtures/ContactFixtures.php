<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $contact = new Contact();
        $contact->setAddress($faker->address)
            ->setEmail($faker->email)
            ->setNumberphone($faker->e164PhoneNumber);
        $manager->persist($contact);
        $manager->flush();
    }
}
