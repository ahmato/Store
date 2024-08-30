<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $product1 = new Product(
            id: 0,
            name: 'Laptop',
            stock: 50,
            description: 'A high-performance laptop with 16GB RAM and 512GB SSD.',
            price: '1299.99',
            imagePath: '/images/laptop.png'
        );

        $product2 = new Product(
            id: 0,
            name: 'Smartphone',
            stock: 200,
            description: 'Latest smartphone with excellent camera and battery life.',
            price: '799.99',
            imagePath: '/images/smartphone.png'
        );

        $manager->persist($product1);
        $manager->persist($product2);

        $manager->flush();
    }
}
