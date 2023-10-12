<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Response\CartResponseDTO;

interface CartServiceInterface
{
    public function getCart(int $cartId): CartResponseDTO|null;

    public function addProduct(int $cartId, int $productId): void;

    public function removeProduct(int $cartId, int $productId): void;

    public function updateProduct(int $cartId, int $productId, int $quantity): void;
}
