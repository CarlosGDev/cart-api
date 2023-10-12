<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CartItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CartItem>
 */
class CartItemRepository extends ServiceEntityRepository implements CartItemRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartItem::class);
    }

    public function findOneCartItemById(int $cartId): CartItem|null
    {
        return $this->findOneBy(['id' => $cartId]);
    }

    public function save(CartItem $cartItem): void
    {
        $this->getEntityManager()->persist($cartItem);
        $this->getEntityManager()->flush();
    }

    public function findOneCartItemByCartAndProduct(int $cartId, int $productId): CartItem|null
    {
        return $this->findOneBy(['cart' => $cartId, 'product' => $productId]);
    }
}
