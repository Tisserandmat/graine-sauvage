<?php

namespace App\DataFixtures;

use App\Entity\Seed;
use App\Entity\Vegetable;
use App\Repository\VegetableRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class VegetableFixtures extends Fixture
{
    public function getDependencies()
    {
        // TODO: Implement getDependencies() method.
        return [SeedFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        ;
        for ($i = 0; $i < 15; $i++) {
            $vegetable = new Vegetable();
            $vegetable->setName($faker->name)
                ->setDescription($faker->text)
                ->setFamily('famille de légume ' . $i)
                ->setHarvestMonth($faker->monthName)
                ->setLatinName('nom latin ' .$i)
                ->setSoilType($faker->word)
                ->setSize($faker->numberBetween(0, 100))
                ->setSlug($faker->slug)
                ->setType('Type de légume ' . $i)
                ->setSeed($this->getReference('seed_'. $i));
             $manager->persist($vegetable);
        }
        $manager->flush();
    }
}
