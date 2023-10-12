<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Repository\CartItemRepository;
use App\Repository\ProductRepository;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Assert;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class CartContext implements Context
{
    private const LOCAL_URL = 'http://nginx';

    private HttpClientInterface $client;

    private EntityManagerInterface $entityManager;

    private ResponseInterface|null $response;

    private Product $product;

    private int $cartId;

    /**
     * @var array<string, mixed>
     */
    private array $body = [];

    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $client)
    {
        $this->client = $client;
        $this->entityManager = $entityManager;
    }

    /**
     * @Given the cart exist
     */
    public function theCartExist(): void
    {
        $this->cartId = 1;
    }

    /**
     * @Given /^is not empty$/
     */
    public function isNotEmpty(): void
    {
        $repo = $this->entityManager->getRepository(Cart::class);
        $result = $repo->find($this->cartId);
        Assert::assertGreaterThan(0, $result->getCartItems()->count());
    }

    /**
     * @When I request :method :resource
     */
    public function iRequest(string $method, string $resource): void
    {
        $this->response = $this->client->request($method, self::LOCAL_URL.$resource, $this->body);
    }

    /**
     * @Then the response status code should be :code
     */
    public function theResponseStatusCodeShouldBe(int $code): void
    {
        Assert::assertEquals($code, $this->response->getStatusCode());
    }

    /**
     * @Given the product :productName exist
     */
    public function theProductExist(string $productName): void
    {
        $this->product = $this->entityManager->getRepository(Product::class)->findOneBy(['name' => $productName]);
        Assert::assertNotNull($this->product);
    }

    /**
     * @Given product is not in cart :cartId
     */
    public function productIsNotInCart(int $cartId): void
    {
        /** @var CartItemRepository $cartItemRepo */
        $cartItemRepo = $this->entityManager->getRepository(CartItem::class);
        $cartItem = $cartItemRepo->findOneCartItemByCartAndProduct($cartId, $this->product->getId());
        Assert::assertNull($cartItem);
    }

    /**
     * @Given the product :productName exist in cart :cartId
     */
    public function theProductExistInCart(string $productName, int $cartId): void
    {
        /** @var ProductRepository $productRepo */
        $productRepo = $this->entityManager->getRepository(Product::class);
        $product = $productRepo->findOneBy(['name' => $productName]);
        /** @var CartItemRepository $cartItemRepo */
        $cartItemRepo = $this->entityManager->getRepository(CartItem::class);
        $cartItem = $cartItemRepo->findOneCartItemByCartAndProduct($cartId, $product->getId());
        Assert::assertNotNull($cartItem);
    }

    /**
     * @Given I have the payload:
     */
    public function iHaveThePayload(PyStringNode $payload): void
    {
        $this->body = ['body' => json_decode($payload->getRaw(), true)];
    }
}
