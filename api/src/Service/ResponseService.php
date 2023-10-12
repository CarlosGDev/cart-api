<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\NormalizeException;
use App\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ResponseService implements ResponseServiceInterface
{
    private const METHOD_GET = 'GET';
    private const METHOD_POST = 'POST';
    private const METHOD_PUT = 'PUT';
    private const METHOD_DELETE = 'DELETE';

    private CartServiceInterface $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function getResponse(string $requestMethod, int $cartId, int $productId = null, int $quantity = null): JsonResponse
    {
        try {
            $data = [];
            $status = Response::HTTP_OK;

            switch ($requestMethod) {
                case self::METHOD_GET:
                    $data = $this->cartService->getCart($cartId);
                    $normalizers = [new ObjectNormalizer()];
                    $serializer = new Serializer($normalizers, []);
                    $data = $serializer->normalize($data, 'json');
                    break;
                case self::METHOD_POST:
                    $this->cartService->addProduct($cartId, $productId);
                    $status = Response::HTTP_CREATED;
                    break;
                case self::METHOD_PUT:
                    $this->cartService->updateProduct($cartId, $productId, $quantity);
                    $status = Response::HTTP_NO_CONTENT;
                    break;
                case self::METHOD_DELETE:
                    $this->cartService->removeProduct($cartId, $productId);
                    $status = Response::HTTP_NO_CONTENT;
                    break;
                default:
            }

            return new JsonResponse($data, $status);
        } catch (NotFoundException $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (NormalizeException $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
