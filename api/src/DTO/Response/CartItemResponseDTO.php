<?php

declare(strict_types=1);

namespace App\DTO\Response;

class CartItemResponseDTO
{
    private int $id;

    private int $quantity;

    private ProductResponseDTO $product;

    public function __construct(int $id, int $quantity, ProductResponseDTO $product)
    {
        $this->id = $id;
        $this->quantity = $quantity;
        $this->product = $product;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getProduct(): ProductResponseDTO
    {
        return $this->product;
    }
}
