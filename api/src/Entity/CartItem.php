<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CartItemRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity(repositoryClass: CartItemRepository::class)]
class CartItem
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    private int $id;

    #[Column(name: 'quantity')]
    private int $quantity;

    #[ManyToOne(
        targetEntity: Cart::class,
        cascade: ['merge', 'detach', 'persist', 'refresh'],
        inversedBy: 'cartItems'
    )]
    #[JoinColumn(name: 'cart_id', referencedColumnName: 'id')]
    private Cart $cart;

    #[ManyToOne(targetEntity: Product::class)]
    #[JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    private Product $product;

    public function __construct(Product $product, int $quantity = 1)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function setCart(Cart $cart): void
    {
        $this->cart = $cart;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
}
