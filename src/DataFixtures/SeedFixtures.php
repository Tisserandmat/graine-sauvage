<?php

namespace App\DataFixtures;

use App\Entity\Seed;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class SeedFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i <= 15; $i++) {
            $seed = new Seed();
            $seed->setName($faker->name)
                ->setDescription($faker->text)
                ->setSeeding($faker->monthName)
                ->setPrice($i);
            $manager->persist($seed);
            $this->addReference('seed_'. $i, $seed);
        }

        $manager->flush();
    }
}
