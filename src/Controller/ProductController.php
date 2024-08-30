<?php

namespace App\Controller;

use AllowDynamicProperties;
use App\Entity\Product;
use App\Form\ProductFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[AllowDynamicProperties] class ProductController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->productRepository = $this->entityManager->getRepository(Product::class);
    }

    #[Route('/', name: 'products', methods: ['GET', 'HEAD'])]
    public function index(): Response
    {
        $products = $this->productRepository->findBy([], ['id' => 'DESC']);

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/create', name: 'create_product')]
    public function create(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductFormType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newProduct = $form->getData();

            $this->entityManager->persist($newProduct);
            $this->entityManager->flush();

            return $this->redirectToRoute('products');
        }

        return $this->render('product/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/product/{id}', name: 'show-product', defaults: ['name' => null], methods: ['GET'])]
    public function showProduct(string $id): JsonResponse|Response
    {
        if (!$id) {
            return $this->json(['error: Product name is required. ', Response::HTTP_BAD_REQUEST]);
        }

        $product = $this->productRepository->find($id);

        if (!$product) {
            return $this->json(['error: Product not found', Response::HTTP_NOT_FOUND]);
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }


    #[Route('/product/{name}/{price}', methods: 'GET'), ]
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