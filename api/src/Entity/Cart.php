<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;

#[Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    private int $id;

    /**
     * @var ArrayCollection<int, CartItem>|Collection<int, CartItem>
     */
    #[OneToMany(
        mappedBy: 'cart',
        targetEntity: CartItem::class,
        cascade: ['merge', 'detach', 'persist', 'refresh']
    )]
    private Collection|ArrayCollection $cartItems;

    public function __construct()
    {
        $this->cartItems = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Collection<int, CartItem>
     */
    public function getCartItems(): Collection
    {
        return $this->cartItems;
    }

    /**
     * @param Collection<int, CartItem> $cartItems
     */
    public function setCartItems(Collection $cartItems): void
    {
        $this->cartItems = $cartItems;
    }

    public function addCartItem(CartItem $cartItem): void
    {
        $this->cartItems->add($cartItem);
        $cartItem->setCart($this);
    }

    public function removeCartItem(CartItem $cartItem): void
    {
        if ($this->cartItems->contains($cartItem)) {
            $this->cartItems->removeElement($cartItem);
        }
    }
}
