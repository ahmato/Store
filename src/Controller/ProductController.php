<?php

namespace App\Controller;

use AllowDynamicProperties;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[AllowDynamicProperties] class ProductController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->productRepository = $this->entityManager->getRepository(Product::class);
    }

    #[Route('/products', name: 'products', methods: ['GET', 'HEAD'])]
    public function index(): Response
    {
        $products = $this->productRepository->findBy([], ['id' => 'DESC']);

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/{name}', name: 'product', defaults: ['name' => null], methods: ['GET'])]
    public function product(string $name): JsonResponse
    {
        if (!$name) {
            return $this->json(['error: Product name is required. ', Response::HTTP_BAD_REQUEST]);
        }

        $product = $this->productRepository->findOneBy([]);

        if (!$product) {
            return $this->json(['error: Product not found', Response::HTTP_NOT_FOUND]);
        }

        return $this->json([
            'message' => 'Welcome to your new controller! => ' . $name,
            'path' => 'src/Controller/ProductController.php',
        ]);
    }

    #[Route('/products/{name}/{price}', methods: 'GET'), ]
    public function getProductByNameAndPrice(string $name, float $price): JsonResponse
    {
        if (empty($name) || empty($price)) {
            return $this->json([
                'error: product name and price are required', Response::HTTP_BAD_REQUEST]);
        }

        $products = $this->productRepository->findProductsByNameAndPrice($name, $price);

        if (!$products) {
            return $this->json(['error: Product not found', Response::HTTP_NOT_FOUND]);
        }

        return $this->json($products);
    }
}