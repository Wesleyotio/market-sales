<?php

declare(strict_types=1);

namespace App\Domain\Dtos;

readonly class ProductDto
{
    public function __construct(
        private int $code,
        private int $typeProductId,
        private string $name,
        private float $value
    ) {
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getTypeProductId(): int
    {
        return $this->typeProductId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
