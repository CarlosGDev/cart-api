<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Request\CartItemRequestDTO;
use App\Service\ResponseServiceInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
#[OA\Tag(name: 'Carts')]
class CartController extends AbstractController
{
    private ResponseServiceInterface $responseFactoryService;

    public function __construct(ResponseServiceInterface $responseFactoryService)
    {
        $this->responseFactoryService = $responseFactoryService;
    }

    #[Route('/carts/{cartId}', name: 'carts_show', methods: 'GET')]
    public function show(int $cartId): JsonResponse
    {
        return $this->responseFactoryService->getResponse('GET', $cartId);
    }

    #[Route('/carts/{cartId}/products/{productId}', name: 'carts_add', methods: 'POST')]
    public function add(int $cartId, int $productId): JsonResponse
    {
        return $this->responseFactoryService->getResponse('POST', $cartId, $productId);
    }

    #[Route('/carts/{cartId}/products/{productId}', name: 'carts_remove', methods: 'DELETE')]
    public function remove(int $cartId, int $productId): JsonResponse
    {
        return $this->responseFactoryService->getResponse('DELETE', $cartId, $productId);
    }

    #[OA\Put(requestBody: new OA\RequestBody(content: new OA\JsonContent(properties: [new OA\Property(property: 'quantity', type: 'int')])))]
    #[Route('/carts/{cartId}/products/{productId}', name: 'carts_update', methods: 'PUT')]
    public function update(int $cartId, int $productId, #[MapRequestPayload] CartItemRequestDTO $cartItemRequestDTO): JsonResponse
    {
        return $this->responseFactoryService->getResponse('PUT', $cartId, $productId, $cartItemRequestDTO->quantity);
    }
}
