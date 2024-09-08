<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
//        $product2->setImagePath('/images/smartphone.png');

        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $product = new Product();
            $product->setName(ucfirst($faker->word));
            $product->setStock($faker->numberBetween(0, 100));
            $product->setDescription($faker->sentence);
            $product->setPrice($faker->randomFloat(2, 10, 2000));
            $product->setImagePath('/images/' . $faker->word . '.png');

            $manager->persist($product);
        }

        $manager->flush();
    }
}
