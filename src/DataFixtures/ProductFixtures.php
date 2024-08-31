<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product1 = new Product();
        $product1->setName('Laptop');
        $product1->setStock(50);
        $product1->setDescription('A high-performance laptop with 16GB RAM and 512GB SSD.');
        $product1->setPrice('1299.99');
        $product1->setImagePath('/images/laptop.png');

        $product2 = new Product();
        $product2->setName('Smartphone');
        $product2->setStock(200);
        $product2->setDescription('Latest smartphone with excellent camera and battery life.');
        $product2->setPrice('799.99');
        $product2->setImagePath('/images/smartphone.png');

        $manager->persist($product1);
        $manager->persist($product2);

        $manager->flush();
    }
}
