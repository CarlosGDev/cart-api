<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Cart;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CartFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $csvEncoder = new CsvEncoder();
        $serializer = new Serializer([new ObjectNormalizer()], [$csvEncoder]);
        $data = $serializer->decode((string) file_get_contents(__DIR__.'/Resources/cart.csv'), 'csv');

        foreach ($data as $cartData) {
            $cart = new Cart();
            $manager->persist($cart);
            $this->addReference('cart_'.$cartData['id'], $cart);
        }

        $manager->flush();
    }
}
