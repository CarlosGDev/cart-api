<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CartItem;

interface CartItemRepositoryInterface
{
    public function findOneCartItemById(int $cartId): CartItem|null;

    public function save(CartItem $cartItem): void;

    public function findOneCartItemByCartAndProduct(int $cartId, int $productId): CartItem|null;
}
