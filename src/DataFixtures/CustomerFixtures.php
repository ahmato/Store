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
        $productRepo = $manager->getRepository(Product::class);
        $product1 = $productRepo->findOneBy(['name' => 'Laptop']);
        $product2 = $productRepo->findOneBy(['name' => 'Smartphone']);

        $customer1 = new Customer();
        $customer1->setName('John Doe');
        $customer1->setEmail('john.doe@example.com');
        $customer1->setAddress('123 Elm Street, Springfield');
        $customer1->setPhone('555-1234');
        if ($product1) {
            $customer1->addProduct($product1);
        }
        if ($product2) {
            $customer1->addProduct($product2);
        }

        $customer2 = new Customer  ();
        $customer2->setName('Jane Smith');
        $customer2->setEmail('jane.smith@example.com');
        $customer2->setAddress('456 Oak Avenue, Springfield');
        $customer2->setPhone('555-5678');
        if ($product1) {
            $customer2->addProduct($product1);
        }

        $manager->persist($customer1);
        $manager->persist($customer2);

        $manager->flush();
    }
}
