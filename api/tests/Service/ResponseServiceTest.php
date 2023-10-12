<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\DTO\Response\CartResponseDTO;
use App\Exception\NormalizeException;
use App\Exception\NotFoundException;
use App\Service\CartService;
use App\Service\ResponseService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class ResponseServiceTest extends TestCase
{
    public function testGetResponseForGetRequest(): void
    {
        $cartServiceMock = $this->createMock(CartService::class);
        $cartServiceMock->expects(self::once())
            ->method('getCart')
            ->willReturn(new CartResponseDTO(1, []));
        $service = new ResponseService($cartServiceMock);
        $response = $service->getResponse('GET', 1);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testGetResponseForPostRequest(): void
    {
        $cartServiceMock = $this->createMock(CartService::class);
        $cartServiceMock->expects(self::once())
            ->method('addProduct');
        $service = new ResponseService($cartServiceMock);
        $response = $service->getResponse('POST', 2, 1);
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    public function testGetResponseForPUTRequest(): void
    {
        $cartServiceMock = $this->createMock(CartService::class);
        $cartServiceMock->expects(self::once())
            ->method('updateProduct');
        $service = new ResponseService($cartServiceMock);
        $response = $service->getResponse('PUT', 3, 2, 11);
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testGetResponseForDELETERequest(): void
    {
        $cartServiceMock = $this->createMock(CartService::class);
        $cartServiceMock->expects(self::once())
            ->method('removeProduct');
        $service = new ResponseService($cartServiceMock);
        $response = $service->getResponse('DELETE', 14, 12);
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testGetResponseForResourceNotFount(): void
    {
        $cartServiceMock = $this->createMock(CartService::class);
        $cartServiceMock->expects(self::once())
            ->method('removeProduct')
            ->willThrowException(new NotFoundException('product not fount'));
        $service = new ResponseService($cartServiceMock);
        $response = $service->getResponse('DELETE', 14, 12);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testGetResponseForHttpInternalServerError(): void
    {
        $cartServiceMock = $this->createMock(CartService::class);
        $cartServiceMock->expects(self::once())
            ->method('getCart')
            ->willThrowException(new NormalizeException('failed serialization'));
        $service = new ResponseService($cartServiceMock);
        $response = $service->getResponse('GET', 6);
        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }
}
