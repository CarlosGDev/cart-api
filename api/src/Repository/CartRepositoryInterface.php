<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Cart;
use App\Entity\CartItem;

interface CartRepositoryInterface
{
    public function findOneCartById(int $cartId): Cart|null;

    public function save(Cart $cart): void;

    public function deleteItem(CartItem $cartItem): void;
}
