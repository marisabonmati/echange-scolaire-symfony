<?php

namespace App\DataFixtures;

use App\Entity\Publication;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PublicationFixtures extends Fixture implements DependentFixtureInterface
{
    const PUBLICATION_COUNT = 20;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i < self::PUBLICATION_COUNT; $i++) {
            $publication = new Publication();
            $publication->setDescriptionPost($faker->text);
            $publication->setTitle($faker->randomElement(['Echange', 'Hôte', 'Accueil']));
            $publication->setPicture($faker->imageUrl($width=500, $height=400, 'people'));
            $publication->setUserPost($this->getReference('user' . random_int(0, UserFixtures::USER_COUNT -1)));
            $manager->persist($publication);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
