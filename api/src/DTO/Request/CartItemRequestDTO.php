<?php

declare(strict_types=1);

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;

class CartItemRequestDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public int $quantity,
    ) {
    }
}
