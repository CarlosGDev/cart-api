<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductRepositoryTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testFindAllProducts(): void
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = static::getContainer()->get('doctrine');
        /** @var ProductRepository $repo */
        $repo = $entityManager->getRepository(Product::class);
        $products = $repo->findAllProducts();
        $this->assertCount(2, $products);
    }

    public function testFindOneProductById(): void
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = static::getContainer()->get('doctrine');
        /** @var ProductRepository $repo */
        $repo = $entityManager->getRepository(Product::class);
        $product = $repo->findOneProductById(1);
        $this->assertEquals('poco5x', $product->getName());
    }
}
