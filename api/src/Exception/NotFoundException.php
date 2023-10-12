<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Validator\Exception\ExceptionInterface;

class NotFoundException extends \Exception implements ExceptionInterface
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
