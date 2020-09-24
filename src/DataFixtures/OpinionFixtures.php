<?php

namespace App\DataFixtures;

use App\Entity\Opinion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OpinionFixtures extends Fixture implements DependentFixtureInterface
{
    const OPINION_COUNT = 5;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i < self::OPINION_COUNT; $i++) {
            $opinion = new Opinion();
            $opinion->setDescriptionOpinion($faker->text);
            $opinion->setStars($faker->randomElement(['1', '2', '3', '4', '5']));
            $opinion->setCommentator($this->getReference('user' . random_int(0, UserFixtures::USER_COUNT -1)));
            $manager->persist($opinion);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
