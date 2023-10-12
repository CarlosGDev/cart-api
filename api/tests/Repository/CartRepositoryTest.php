<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CartRepositoryTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testFindCardById(): void
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = static::getContainer()->get('doctrine');
        /** @var CartRepository $cartRepo */
        $cartRepo = $entityManager->getRepository(Cart::class);
        $cart = $cartRepo->findOneCartById(1);
        /** @var CartItem[] $cartItems */
        $cartItems = $cart->getCartItems();
        $this->assertCount(1, $cartItems);
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->getProduct();
            $this->assertEquals(3, $cartItem->getQUantity());
            $this->assertEquals('poco5x', $product->getName());
            $this->assertEquals('smartphone', $product->getDescription());
            $this->assertEquals('200', $product->getPrice());
        }
    }

    public function testSaveCart(): void
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = static::getContainer()->get('doctrine');
        /** @var CartRepository $cartRepo */
        $cartRepo = $entityManager->getRepository(Cart::class);
        $cart = $cartRepo->findOneCartById(1);
        $this->assertCount(1, $cart->getCartItems());
        $product = $entityManager->getRepository(Product::class)->findOneBy(['id' => 2]);
        $cartItem = new CartItem($product, 8);
        $cart->addCartItem($cartItem);
        $cartRepo->save($cart);
        $changedCart = $cartRepo->findOneCartById(1);
        $this->assertCount(2, $changedCart->getCartItems());
    }

    public function testDeleteItemFromCart(): void
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = static::getContainer()->get('doctrine');
        /** @var CartRepository $cartRepo */
        $cartRepo = $entityManager->getRepository(Cart::class);
        $cartItemRepo = $entityManager->getRepository(CartItem::class);
        $cart = $cartRepo->findOneBy(['id' => 1]);
        $this->assertCount(1, $cart->getCartItems());
        $cartItem = $cartItemRepo->findOneBy(['id' => 1]);
        $cartRepo->deleteItem($cartItem);
        $changedCart = $cartRepo->findOneCartById(1);
        $this->assertCount(0, $changedCart->getCartItems());
    }
}
