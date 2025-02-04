<?php

declare(strict_types=1);

namespace App\Application\Dtos;

use App\Application\Exceptions\ProductException;
use App\Domain\Entities\Product;
use DateTimeImmutable;
use TypeError;

class ProductUpdateDto
{
    public function __construct(
        private ?int $code = null,
        private ?int $typeProductId = null,
        private ?string $name = null,
        private ?float $value = null,
        private ?DateTimeImmutable $updatedAt = null,
    ) {
    }

    public static function fromRequest(array $productData): self
    {

        $arrayKeys = ['code', 'type_product_id', 'name', 'value'];

        if (! validateKeysContainedInArray(array_keys($productData), $arrayKeys)) {
            throw new ProductException("unknown fields are being passed for product update");
        }

        foreach ($productData as $key => $value) {
            if (($key == 'code') && (!is_int($value)) && ($value <= 0)) {
                throw new TypeError("O parâmetro code: {$value} precisa ser do tipo Inteiro maior que zero");
            }

            if (($key == 'type_product_id') && !is_int($value) && ($value <= 0)) {
                throw new TypeError("O parâmetro type_product_id: {$value} precisa ser do tipo Inteiro maior que zero");
            }

            if (($key == 'name') && !is_string($value) && (!empty($value))) {
                throw new TypeError("O parâmetro name: {$value} precisa ser do tipo string não vazia");
            }

            if (($key == 'value') && (!is_float($value)) && ($value <= 0)) {
                throw new TypeError("O parâmetro value: {$value} precisa ser do tipo float maior que zero");
            }
        }

        return new self(
            code:  $productData['code'] ?? null,
            typeProductId: $productData['type_product_id'] ?? null,
            name: $productData['name'] ?? null,
            value: $productData['value'] ?? null
        );
    }

    public static function fromEntity(Product $product): self
    {
        return new self(
            code: $product->getCode(),
            typeProductId: $product->getTypeProductId(),
            name: $product->getName(),
            value: $product->getValue(),
            updatedAt: $product->getUpdatedAt()
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'code' => $this->code,
            'type_product_id' => $this->typeProductId,
            'name' => $this->name,
            'value' => $this->value,

        ], function ($value, $key) {
            return !in_array($key, ['code','type_product_id', 'name', 'value']) || !empty($value);
        }, ARRAY_FILTER_USE_BOTH);
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

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
