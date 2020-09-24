<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
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
            $password = $this->encoder->encodePassword($user, 'user');
            $user->setPassword($password);
            $user->setAdress($faker->address);
            $user->setCp($faker->numberBetween(10000, 99999));
            $user->setCity($faker->city);
            $user->setCountry($faker->country);
            $user->setDescriptionProfil($faker->text);
            $user->getDescriptionSecondary($faker->text);
            $user->setPhone($faker->phoneNumber);
            $user->setCapacity($faker->randomNumber([20, 30, 40]));
            $user->setLanguage($faker->randomElement(['anglais', 'français', 'español', 'italiano']));
            $user->setPhoto($faker->imageUrl($width=500, $height=400, 'people'));
            $datetimeStart = $faker->dateTimeBetween('0 years', '+2 years' );
            $user->setDisponibilityDateStart($datetimeStart);
            $user->setDisponibilityDateEnd($faker->dateTime($datetimeStart, '+2 years' ));
            $user->setLevel($faker->randomElement(['lycée', 'collège']));
            $user->setOptions($faker->randomElement(['échange', 'accueil', 'hôte']));
            $this->addReference('user' . $i, $user);
            $manager->persist($user);
        }
        $manager->flush();
    }
}