<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $manager->persist(
            $this->createUser('test@test.com', '123456')
        );

        for ($index = 0; $index < 20; $index++) {
            $manager->persist(
                $this->createUser($faker->email, $faker->password)
            );
        }

        $manager->flush();
    }

    public function createUser(string $email, string $password): UserInterface
    {
        $user = new User();

        $user->setEmail($email);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $password
        );

        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_USER']);

        return $user;
    }

    public function getOrder(): int
    {
        return 1;
    }
}
