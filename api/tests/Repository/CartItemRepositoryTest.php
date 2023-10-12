<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\CartItem;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CartItemRepositoryTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testFindOneCartItemByCartAndProduct(): void
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = static::getContainer()->get('doctrine');
        $repo = $entityManager->getRepository(CartItem::class);
        $cartItem = $repo->findOneCartItemByCartAndProduct(1, 1);
        $this->assertEquals(3, $cartItem->getQuantity());
    }

    public function testFindOneCartItemById(): void
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = static::getContainer()->get('doctrine');
        $repo = $entityManager->getRepository(CartItem::class);
        $cartItem = $repo->findOneCartItemById(1);
        $this->assertEquals('poco5x', $cartItem->getProduct()->getName());
    }

    public function testSave(): void
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = static::getContainer()->get('doctrine');
        $repo = $entityManager->getRepository(CartItem::class);
        $product = $entityManager->getRepository(Product::class)->findOneBy(['id' => 2]);
        $cartItem = new CartItem($product, 2);
        $repo->save($cartItem);
        $savedCartItem = $repo->findOneBy(['product' => 2]);
        $this->assertEquals(2, $savedCartItem->getQuantity());
    }
}
