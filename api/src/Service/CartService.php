<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Response\CartItemResponseDTO;
use App\DTO\Response\CartResponseDTO;
use App\DTO\Response\ProductResponseDTO;
use App\Entity\Cart;
use App\Entity\CartItem;
use App\Exception\NotFoundException;
use App\Repository\CartItemRepositoryInterface;
use App\Repository\CartRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;

class CartService implements CartServiceInterface
{
    private CartItemRepositoryInterface $cartItemRepository;

    private CartRepositoryInterface $cartRepository;

    private ProductRepositoryInterface $productRepository;

    public function __construct(CartItemRepositoryInterface $cartItemRepository, CartRepositoryInterface $cartRepository, ProductRepositoryInterface $productRepository)
    {
        $this->cartItemRepository = $cartItemRepository;
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @throws NotFoundException
     */
    public function getCart(int $cartId): CartResponseDTO
    {
        $cart = $this->cartRepository->findOneCartById($cartId);
        $this->validateObj($cart, 'Cart', $cartId);

        return $this->createCartResponseDTO($cart);
    }

    /**
     * @throws NotFoundException
     */
    public function addProduct(int $cartId, int $productId): void
    {
        $cart = $this->cartRepository->findOneCartById($cartId);
        $this->validateObj($cart, 'Cart', $cartId);
        $product = $this->productRepository->findOneProductById($productId);
        $this->validateObj($product, 'Product', $productId);
        $cartItem = $this->cartItemRepository->findOneCartItemByCartAndProduct($cartId, $productId);
        if (!$cartItem) {
            $cartItem = new CartItem($product);
            $cart->addCartItem($cartItem);
            $this->cartRepository->save($cart);
        }
    }

    /**
     * @throws NotFoundException
     */
    public function removeProduct(int $cartId, int $productId): void
    {
        $cart = $this->cartRepository->findOneCartById($cartId);
        $this->validateObj($cart, 'Cart', $cartId);
        $cartItem = $this->cartItemRepository->findOneCartItemByCartAndProduct($cartId, $productId);
        $this->validateObj($cartItem, 'Product', $productId);
        $cart->removeCartItem($cartItem);
        $this->cartRepository->deleteItem($cartItem);
    }

    /**
     * @throws NotFoundException
     */
    public function updateProduct(int $cartId, int $productId, int $quantity): void
    {
        $cartItem = $this->cartItemRepository->findOneCartItemByCartAndProduct($cartId, $productId);
        $this->validateObj($cartItem, 'Product', $productId);
        $cartItem->setQuantity($quantity);
        $this->cartItemRepository->save($cartItem);
    }

    /**
     * @throws NotFoundException
     */
    private function validateObj(mixed $obj, string $objName, int $id): void
    {
        if (!$obj) {
            throw new NotFoundException(sprintf($objName.' with ID [%s] not found', $id));
        }
    }

    private function createCartResponseDTO(Cart $cart): CartResponseDTO
    {
        /** @var CartItem[] $cartItems */
        $cartItems = $cart->getCartItems();
        $cartItemsDto = new ArrayCollection();
        foreach ($cartItems as $cartItem) {
            $productDto = new ProductResponseDTO(
                $cartItem->getProduct()->getId(),
                $cartItem->getProduct()->getName(),
                $cartItem->getProduct()->getDescription(),
                $cartItem->getProduct()->getPrice(), );

            $cartItemDto = new CartItemResponseDTO(
                $cartItem->getId(),
                $cartItem->getQuantity(),
                $productDto);

            $cartItemsDto->add($cartItemDto);
        }

        return new CartResponseDTO(
            $cart->getId(),
            $cartItemsDto->toArray()
        );
    }
}
