<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;

interface ProductRepositoryInterface
{
    /**
     * @return array<Product>
     */
    public function findAllProducts(): array;

    public function findOneProductById(int $productId): Product|null;
}
