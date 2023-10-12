<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ProductServiceInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
#[OA\Tag(name: 'Products')]
class ProductController extends AbstractController
{
    #[Route('/products', name: 'products', methods: 'GET')]
    public function show(ProductServiceInterface $productService): JsonResponse
    {
        $data = $productService->getProducts();

        return $this->json($data, Response::HTTP_OK);
    }
}
