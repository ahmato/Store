<?php

namespace App\EventListener;

use App\Event\ProductPurchasedEvent;
use App\Service\EmailService;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

#[AsEventListener(event: ProductPurchasedEvent::NAME, method: 'onProductPurchased')]
class ProductPurchaseEmailNotificationListener
{
    public function __construct(private EmailService $emailService)
    {
    }

    #[NoReturn] public function onProductPurchased(ProductPurchasedEvent $event): void
    {
        $customerEmail = $event->getCustomer()->getEmail();
        $subject = 'Product Purchased';
        $body = sprintf(
            'Dear %s, your purchase of the product %s has been successful!',
            $event->getCustomer()->getName(),
            $event->getProduct()->getName()
        );

        try {

            $this->emailService->sendEmail($customerEmail, $subject, $body);

        } catch (TransportExceptionInterface $e) {
            // Log the exception or handle it as needed
            // For example: log to a file, or display a user-friendly error
        }
    }
}