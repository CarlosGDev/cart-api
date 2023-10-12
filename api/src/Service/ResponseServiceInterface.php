<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;

interface ResponseServiceInterface
{
    public function getResponse(string $requestMethod, int $cartId, int $productId = null, int $quantity = null): JsonResponse;
}
