<?php

namespace App\DataFixtures;

use App\Entity\customer;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $productRepo = $manager->getRepository(Product::class);
        $product1 = $productRepo->findOneBy(['id' => 1]);
        $product2 = $productRepo->findOneBy(['id' => 2]);

        $customer1 = new Customer();
        $customer1->setName($faker->name);
        $customer1->setEmail($faker->email);
        $customer1->setAddress($faker->address);
        $customer1->setPhone($faker->phoneNumber);

        if ($product1) {
            $customer1->addProduct($product1);
        }
        if ($product2) {
            $customer1->addProduct($product2);
        }

        $customer2 = new Customer();
        $customer2->setName($faker->name);
        $customer2->setEmail($faker->email);
        $customer2->setAddress($faker->address);
        $customer2->setPhone($faker->phoneNumber);
        if ($product1) {
            $customer2->addProduct($product1);
        }

        $manager->persist($customer1);
        $manager->persist($customer2);

        $manager->flush();
    }
}
