<?php

namespace App\Exception;

use Gedmo\Exception\RuntimeException;

class OutOfStockException extends RuntimeException
{
    public function __construct(string $message = "The product is out of stock!", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}