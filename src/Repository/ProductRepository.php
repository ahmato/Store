<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findProductsByNameAndPrice(string $name, float $price): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.name = :name')
            ->andWhere('p.price = :price')
            ->setParameter('name', $name)
            ->setParameter('price', $price)
            ->getQuery()
            ->getResult();
    }
}
