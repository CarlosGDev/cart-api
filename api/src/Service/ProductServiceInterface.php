<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;

interface ProductServiceInterface
{
    /**
     * @return array<Product>
     */
    public function getProducts(): array;
}
