<?php

namespace App\Controller;

use AllowDynamicProperties;
use App\Entity\Product;
use App\Form\ProductFormType;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;

#[AllowDynamicProperties] class ProductController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager, private EmailService $mailerService)
    {
        $this->productRepository = $this->entityManager->getRepository(Product::class);
    }


    /**
     * @throws InvalidArgumentException
     */
    #[Route('/', name: 'products', methods: ['GET', 'HEAD'])]
    public function index(CacheInterface $cache): Response
    {
        $products = $cache->get('product_index', function (CacheItemInterface $cacheItem) {
            $cacheItem->expiresAfter(5);
            return $this->productRepository->findAll();
        });

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/create', name: 'create_product', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductFormType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return $this->redirectToRoute('products');
        }

        return $this->render('product/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/product/edit/{id}', name: 'edit_product')]
    public function edit(int $id, Request $request): Response
    {
        $product = $this->productRepository->find($id);

        if (!$product) {
            return $this->json(['error: Product not found', Response::HTTP_NOT_FOUND]);
        }

        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->flush();
            return $this->redirectToRoute('products');
        }

        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/product/delete/{id}', name: 'delete_product', methods: ['POST'])]
    public function delete(int $id): Response
    {
        $product = $this->productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return $this->redirectToRoute('products');
    }

    #[Route('/product/{id}', name: 'show-product', methods: ['GET'])]
    public function show(Product $product, CacheInterface $cache,): Response
    {
        $this->mailerService->sendEmail(
            'gotipa7825@coloruz.com',
            'Test Subject',
            'This is the email body for creating product.'
        );

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @throws InvalidArgumentException
     */
    #[Route('/products/{name}/{price}', methods: 'GET'), ]
    public function getProductByNameAndPrice(string $name, float $price, CacheInterface $cache): JsonResponse
    {
        if (empty($name) || empty($price)) {
            return $this->json([
                'error: product name and price are required', Response::HTTP_BAD_REQUEST]);
        }

        $products = $cache->get('product_' . $name, function () use ($name, $price) {

            return $this->productRepository->findProductsByNameAndPrice($name, $price);
        });

        if (!$products) {
            return $this->json(['error: Product not found', Response::HTTP_NOT_FOUND]);
        }

        return $this->json($products, Response::HTTP_OK);
    }
}