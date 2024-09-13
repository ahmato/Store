<?php

namespace App\Event;

use App\Entity\Customer;
use App\Entity\Product;
use Symfony\Contracts\EventDispatcher\Event;

class ProductPurchasedEvent extends Event
{
    public const NAME = 'product.purchase';
    public function __construct(private Product $product, private Customer $customer)
    {
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }
}