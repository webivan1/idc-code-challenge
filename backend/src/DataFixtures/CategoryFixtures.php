<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($index = 0; $index < mt_rand(5, 10); $index++) {
            $manager->persist($this->createCategory($index));
        }

        $manager->flush();
    }

    public function createCategory(int $index): Category
    {
        $faker = Factory::create();

        $category = new Category();

        $category->setTitle($faker->jobTitle);

        $category->setSlug($faker->slug());
        $category->setPriority($index + 1);

        return $category;
    }

    public function getOrder(): int
    {
        return 2;
    }
}
