<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{

    public function __construct(private MailerInterface $mailer,private string $defaultSenderEmail)
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail(string $to, string $subject, string $body): void
    {
        $email = (new Email())
            ->from($this->defaultSenderEmail)
            ->to($to)
            ->subject($subject)
            ->text($body)
            ->html('<p>Sending emails with <strong>Store</strong> and <strong>Mailtrap</strong>!</p>');


        $this->mailer->send($email);
    }
}
