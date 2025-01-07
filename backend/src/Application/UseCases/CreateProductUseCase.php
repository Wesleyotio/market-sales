<?php

namespace App\Application\UseCases;

use App\Domain\Dtos\ProductDto;
use App\Domain\Repositories\ProductRepositoryInterface;
use TypeError;

class CreateProductUseCase
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function action($code, $type_product_id, $name, $value): void
    {

        if (!is_int($code)) {
            throw new TypeError("O parâmetro code: {$code} precisa ser do tipo Inteiro");
        }

        if (!is_int($type_product_id)) {
            throw new TypeError("O parâmetro type_product_id: {$type_product_id} precisa ser do tipo Inteiro");
        }

        if (!is_string($name)) {
            throw new TypeError("O parâmetro name: {$name} precisa ser do tipo string");
        }

        if (!is_float($value)) {
            throw new TypeError("O parâmetro value: {$value} precisa ser do tipo float");
        }

        $productDto = new ProductDto($code, $type_product_id, $name, $value);

        $this->productRepository->create($productDto);
    }
}
