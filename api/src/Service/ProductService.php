<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;

class ProductService implements ProductServiceInterface
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @return array|Product[]
     */
    public function getProducts(): array
    {
        $products = $this->productRepository->findAllProducts();

        return $this->createProductsDto($products);
    }

    /**
     * @param array<Product> $products
     *
     * @return array<Product>
     */
    private function createProductsDto(array $products): array
    {
        $productsDto = new ArrayCollection();
        foreach ($products as $product) {
            $productDto = new Product($product->getName(), $product->getDescription(), $product->getPrice());
            $productsDto->add($productDto);
        }

        return $productsDto->toArray();
    }
}
