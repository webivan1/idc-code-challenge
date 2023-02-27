<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Todo;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class TodoFixtures extends Fixture implements OrderedFixtureInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly CategoryRepository $categoryRepository,
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $users = $this->userRepository->findAll();
        $categories = $this->categoryRepository->findAll();

        $testUser = $this->userRepository->findOneBy(['email' => 'test@test.com']);

        for ($index = 0; $index < mt_rand(10, 20); $index++) {
            $category = $categories[array_rand($categories)];
            $manager->persist($this->createTodo($testUser, $category, $faker));
        }

        for ($index = 0; $index < mt_rand(50, 100); $index++) {
            $category = $categories[array_rand($categories)];
            $user = $users[array_rand($users)];
            $manager->persist($this->createTodo($user, $category, $faker));
        }

        $manager->flush();
    }

    public function createTodo(User $user, Category $category, Generator $faker): Todo
    {
        $todo = new Todo();

        $todo->setTitle($faker->jobTitle);
        $todo->setIsDone($faker->boolean);
        $todo->setCategory($category);
        $todo->setOwner($user);
        $todo->setCreatedAt(new \DateTimeImmutable());
        $todo->setUpdatedAt(new \DateTimeImmutable());

        return $todo;
    }

    public function getOrder(): int
    {
        return 3;
    }
}
