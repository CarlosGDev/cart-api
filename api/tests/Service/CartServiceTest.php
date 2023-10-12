<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Exception\NotFoundException;
use App\Repository\CartItemRepositoryInterface;
use App\Repository\CartRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use App\Service\CartService;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CartServiceTest extends TestCase
{
    private MockObject $cartRepoMock;

    private MockObject $cartItemRepoMock;

    private MockObject $productRepoMock;

    private CartService $service;

    protected function setUp(): void
    {
        $this->cartRepoMock = $this->createMock(CartRepositoryInterface::class);
        $this->cartItemRepoMock = $this->createMock(CartItemRepositoryInterface::class);
        $this->productRepoMock = $this->createMock(ProductRepositoryInterface::class);
        $this->service = new CartService($this->cartItemRepoMock, $this->cartRepoMock, $this->productRepoMock);
    }

    public function testGetCart(): void
    {
        $productMock = $this->getMockBuilder(Product::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getId', 'getName', 'getDescription', 'getPrice'])
            ->getMock();
        $cartItem = $this->getMockBuilder(CartItem::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getId', 'getQuantity', 'getProduct'])
            ->getMock();
        $cartItem->expects($this->exactly(4))
            ->method('getProduct')
            ->willReturn($productMock);
        $cartItems = new ArrayCollection();
        $cartItems->add($cartItem);
        $cartMock = $this->getMockBuilder(Cart::class)
            ->onlyMethods(['getId', 'getCartItems'])
            ->getMock();
        $cartMock->expects(self::once())
            ->method('getCartItems')
            ->willReturn($cartItems);
        $this->cartRepoMock->expects(self::once())
            ->method('findOneCartById')
            ->willReturn($cartMock);

        $this->service->getCart(3);
    }

    public function testGetCartException(): void
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Cart with ID [2] not found');
        $this->service->getCart(2);
    }

    public function testAddProduct(): void
    {
        $this->cartRepoMock->expects(self::once())
            ->method('findOneCartById')
            ->willReturn(new Cart());
        $this->cartRepoMock->expects(self::once())
            ->method('save');
        $this->productRepoMock->expects(self::once())
            ->method('findOneProductById')
            ->willReturn(new Product('Sony Xperia', 'SmartPhone', 659));

        $this->service->addProduct(1, 2);
    }

    public function testAddProductException(): void
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Cart with ID [5] not found');
        $this->service->addProduct(5, 4);
    }

    public function testUpdateProduct(): void
    {
        $product = new Product('Samsung Galaxy', 'SmartPhone', 959);
        $this->cartItemRepoMock->expects(self::once())
            ->method('findOneCartItemByCartAndProduct')
            ->willReturn(new CartItem($product, 4));
        $this->cartItemRepoMock->expects(self::once())
            ->method('save');

        $this->service->updateProduct(1, 2, 3);
    }

    public function testUpdateProductException(): void
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Product with ID [6] not found');
        $this->service->updateProduct(1, 6, 3);
    }

    public function testRemoveProduct(): void
    {
        $product = new Product('Samsung Galaxy', 'SmartPhone', 959);
        $cartItem = new CartItem($product, 4);
        $cart = new Cart();
        $cartItem->setCart($cart);
        $this->cartItemRepoMock->expects(self::once())
            ->method('findOneCartItemByCartAndProduct')
            ->willReturn($cartItem);
        $this->cartRepoMock->expects(self::once())
            ->method('findOneCartById')
            ->willReturn($cart);

        $this->service->removeProduct(1, 2);
    }

    public function testRemoveProductException(): void
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Cart with ID [8] not found');
        $this->service->removeProduct(8, 2);
    }
}
