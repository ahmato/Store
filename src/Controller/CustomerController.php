<?php

namespace App\Controller;

use App\Entity\customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CustomerController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {

    }

    #[Route('/customer', name: 'app_customer')]
    public function index(): Response
    {
        $customerRepository = $this->entityManager->getRepository(Customer::class);
        $customers = $customerRepository->findAll();

        return $this->render('customer/index.html.twig', [
            'controller_name' => 'CustomerController', $customers
        ]);
    }

    #[Route('/customer/customerId', name: 'customer', methods: ['GET'])]
    public function getCustomer(int $customerId): JsonResponse
    {
        if (!$customerId) {
            return $this->json(['error: Customer id is cannot be null', Response::HTTP_BAD_REQUEST]);
        }

        $customerRepository = $this->entityManager->getRepository(Customer::class);

        $customer = $customerRepository->find($customerId);

        if (!$customer) {
            return $this->json(['error: customer is not found', Response::HTTP_NOT_FOUND]);
        }

        return $this->json([
            $customer
        ]);
    }
}
