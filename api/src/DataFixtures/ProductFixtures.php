<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $csvEncoder = new CsvEncoder();
        $serializer = new Serializer([new ObjectNormalizer()], [$csvEncoder]);
        $data = $serializer->decode((string) file_get_contents(__DIR__.'/Resources/product.csv'), 'csv');

        foreach ($data as $productData) {
            $product = new Product(
                $productData['name'],
                $productData['description'],
                (int) $productData['price'],
            );
            $manager->persist($product);
            $this->addReference('product_'.$productData['id'], $product);
        }

        $manager->flush();
    }
}
