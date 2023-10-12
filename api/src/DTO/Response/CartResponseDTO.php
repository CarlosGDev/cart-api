<?php

declare(strict_types=1);

namespace App\DTO\Response;

use App\Entity\CartItem;

class CartResponseDTO
{
    private int $id;

    /**
     * @var array<CartItem>
     */
    private array $cartItems;

    /**
     * @param array<CartItem> $cartItems
     */
    public function __construct(int $id, array $cartItems)
    {
        $this->id = $id;
        $this->cartItems = $cartItems;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return array<CartItem>
     */
    public function getCartItems(): array
    {
        return $this->cartItems;
    }
}
