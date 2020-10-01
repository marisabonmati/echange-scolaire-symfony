<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    const USER_COUNT = 20;
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setEmail('admin@echange-scolaire.com');
        $admin->setFirstname('admin');
        $admin->setLastname('admin');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->encoder->encodePassword($admin, 'root'));
        $manager->persist($admin);

        $faker = Factory::create('fr_FR');

        for($i = 0; $i < self::USER_COUNT; $i++){
            $user = new User();
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setEmail($faker->email);
            $user->setRoles(['ROLE_USER']);
            $password = $this->encoder->encodePassword($user, 'password');
            $user->setPassword($password);
            $user->setAdress($faker->address);
            $user->setCp($faker->numberBetween(10000, 99999));
            $user->setCity($faker->city);
            $user->setCountry($faker->country);
            $user->setDescriptionProfil($faker->text);
            $user->setDescriptionSecondary($faker->text);
            $user->setPhone($faker->phoneNumber);
            $user->setCapacity($faker->numberBetween(15, 50));
            $user->setLanguage($faker->randomElements(['Anglais', 'Français', 'Espagnol', 'Italien'], random_int(1, 2)));
            $user->setPhoto($faker->imageUrl($width=500, $height=400, 'people'));
            $datetimeStart = $faker->dateTimeBetween('0 years', '+2 years' );
            $user->setDisponibilityDateStart($datetimeStart);
            $user->setDisponibilityDateEnd($faker->dateTime($datetimeStart, '+2 years' ));
            $user->setLevel($faker->randomElements(['lycée', 'collège'], random_int(1, 2)));
            $user->setOptions($faker->randomElement(['échange', 'accueil', 'hôte']));
            for ($j = 0; $j < random_int(0,5); $j++){
                $user->addTag($this->getReference('tag' . random_int(0, TagFixtures::TAG_COUNT -1)));
            }
            $this->addReference('user' . $i, $user);
            $user->setEntite($faker->randomElement(['enseignant', 'etablissement']));
            $manager->persist($user);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [TagFixtures::class];
    }

}
