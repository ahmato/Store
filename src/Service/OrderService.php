<?php

namespace App\Service;

use App\Entity\Customer;
use App\Entity\Product;
use App\Event\ProductPurchasedEvent;
use App\Exception\OutOfStockException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class OrderService
{
    public function __construct(private EntityManagerInterface $entityManager, private EventDispatcherInterface $eventDispatcher)
    {
    }

    public function purchaseProduct(Product $product, Customer $customer): void
    {
        if ($product->getStock() <= 0) {
            throw new OutOfStockException();
        }

        $customer->addProduct($product);

        $product->setStock($product->getStock() - 1);

        $this->entityManager->persist($customer);
        $this->entityManager->persist($product);

        $this->entityManager->flush();


        $event = new ProductPurchasedEvent($product, $customer);
        $this->eventDispatcher->dispatch($event, ProductPurchasedEvent::NAME);

    }
}