<?php

namespace App\DataFixtures;

use App\Entity\customer;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $customer1 = new Customer(
            id: 0,
            name: 'John Doe',
            email: 'john.doe@example.com',
            address: '123 Elm Street, Springfield',
            phone: '555-1234'
        );

        $customer2 = new Customer(
            id: 0,
            name: 'Jane Smith',
            email: 'jane.smith@example.com',
            address: '456 Oak Avenue, Springfield',
            phone: '555-5678'
        );

        $product1 = $manager->getRepository(Product::class)->find(1);
        $product2 = $manager->getRepository(Product::class)->find(2);

        if ($product1) {
            $customer1->addProducts($product1);
            $customer2->addProducts($product1);
        }

        if ($product2) {
            $customer1->addProducts($product2);
        }

        $manager->persist($customer1);
        $manager->persist($customer2);

        $manager->flush();
    }
}
