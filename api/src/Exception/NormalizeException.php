<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Serializer\Exception\ExceptionInterface;

class NormalizeException extends \Exception implements ExceptionInterface
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
