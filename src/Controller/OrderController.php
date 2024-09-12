<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Product;
use App\Exception\OutOfStockException;
use App\Service\OrderService;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\b;

class OrderController extends AbstractController
{
    public function __construct(private OrderService $orderService, private EntityManagerInterface $entityManager)
    {
    }

    #[Route('/purchase/{productId}/{customerId}', name: 'purchase_product', methods: 'POST')]
    public function purchase(int $productId, int $customerId): JsonResponse
    {
        $customer = $this->entityManager->getRepository(Customer::class)->find($customerId);
        $product = $this->entityManager->getRepository(Product::class)->find($productId);

        if (!$product || !$customer) {
            $this->json(['message' => 'Product or Customer not found!'], Response::HTTP_NOT_FOUND);
        }

        try {
            $this->orderService->purchaseProduct($product, $customer);

            return $this->json(['Message' => 'Product purchase successfully!'], Response::HTTP_OK);
        } catch (OutOfStockException $e) {

            return $this->json(['Message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {

            return $this->json(['Message' => 'An unexpected error occurred: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
