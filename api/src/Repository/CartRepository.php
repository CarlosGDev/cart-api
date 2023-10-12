<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Cart;
use App\Entity\CartItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cart>
 */
class CartRepository extends ServiceEntityRepository implements CartRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    public function findOneCartById(int $cartId): Cart|null
    {
        return $this->findOneBy(['id' => $cartId]);
    }

    public function save(Cart $cart): void
    {
        $this->getEntityManager()->persist($cart);
        $this->getEntityManager()->flush();
    }

    public function deleteItem(CartItem $cartItem): void
    {
        $cart = $cartItem->getCart();
        $cart->removeCartItem($cartItem);
        $this->getEntityManager()->remove($cartItem);
        $this->getEntityManager()->flush();
    }
}
