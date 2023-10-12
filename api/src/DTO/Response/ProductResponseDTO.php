<?php

declare(strict_types=1);

namespace App\DTO\Response;

class ProductResponseDTO
{
    private int $id;

    private string $name;

    private string $description;

    private int $price;

    public function __construct(int $id, string $name, string $description, int $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}
