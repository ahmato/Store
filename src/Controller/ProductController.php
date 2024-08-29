<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'products', methods: ['GET', 'HEAD'])]
    public function index(): Response
    {
        $products = ["Mobiles: Iphone X", "Samsung Samsung", "iOS"];
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/{name}', name: 'product', defaults: ['name' => null], methods: ['GET'])]
    public function product(string $name): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller! => ' . $name,
            'path' => 'src/Controller/ProductController.php',
        ]);
    }
}