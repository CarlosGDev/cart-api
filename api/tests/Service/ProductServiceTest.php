<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\ProductService;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    public function testGetProducts(): void
    {
        $productRepoMock = $this->createMock(ProductRepository::class);
        $productRepoMock->expects(self::once())
            ->method('findAllProducts')
            ->willReturn([
                new Product('Apple Mac mini', 'Mini PC', 485),
            ]);
        $service = new ProductService($productRepoMock);
        $products = $service->getProducts();
        $this->assertCount(1, $products);
    }
}
