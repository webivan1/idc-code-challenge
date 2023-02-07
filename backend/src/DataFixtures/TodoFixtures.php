<?php

namespace App\DataFixtures;

use App\Entity\Todo;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class TodoFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $userRepository = $manager->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => 'test@test.com']);

        $faker = Factory::create();

        for ($index = 0; $index < mt_rand(4, 7); $index++) {
            $manager->persist($this->createTodo($user, $faker));
        }

        $manager->flush();
    }

    public function createTodo(User $user, Generator $faker): Todo
    {
        $todo = new Todo();

        $todo->setTitle($faker->jobTitle);
        $todo->setIsDone($faker->boolean);
        $todo->setOwner($user);
        $todo->setCreatedAt(new \DateTimeImmutable());
        $todo->setUpdatedAt(new \DateTimeImmutable());

        return $todo;
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ];
    }

    public function getOrder(): int
    {
        return 2;
    }
}
