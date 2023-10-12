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
        $productMock = $this->getMockBuilder(Product::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getId', 'getPrice', 'getName', 'getDescription'])
            ->getMock();
        $productRepoMock = $this->createMock(ProductRepository::class);
        $productRepoMock->expects(self::once())
            ->method('findAllProducts')
            ->willReturn([$productMock]);
        $service = new ProductService($productRepoMock);
        $products = $service->getProducts();
        $this->assertCount(1, $products);
    }
}
