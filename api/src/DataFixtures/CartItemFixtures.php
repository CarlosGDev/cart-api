<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CartItemFixtures extends Fixture implements DependentFixtureInterface
{
    public const CART_REFERENCE = 'cart_';
    public const PRODUCT_REFERENCE = 'product_';

    public function getDependencies(): array
    {
        return [ProductFixtures::class, CartFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $csvEncoder = new CsvEncoder();
        $serializer = new Serializer([new ObjectNormalizer()], [$csvEncoder]);
        $data = $serializer->decode((string) file_get_contents(__DIR__.'/Resources/cart_item.csv'), 'csv');

        foreach ($data as $cartItemData) {
            /** @var Product $product */
            $product = $this->getReference(name: self::PRODUCT_REFERENCE.$cartItemData['product_id']);
            /** @var Cart $cart */
            $cart = $this->getReference(name: self::CART_REFERENCE.$cartItemData['cart_id']);
            $cartItem = new CartItem(
                $product,
                (int) $cartItemData['quantity']
            );
            $cartItem->setCart($cart);
            $manager->persist($cartItem);
            $this->addReference('cart_item_'.$cartItemData['id'], $cartItem);
        }

        $manager->flush();
    }
}
