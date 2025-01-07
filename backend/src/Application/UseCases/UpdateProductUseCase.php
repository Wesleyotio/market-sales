<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\ProductRepositoryInterface;
use TypeError;

class UpdateProductUseCase
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }


    public function action(int $id, array $productData): ?int
    {
        foreach ($productData as $key => $value) {
            if (($key == 'code') && (!is_int($value))) {
                throw new TypeError("O parâmetro code: {$value} precisa ser do tipo Inteiro");
            }

            if (($key == 'type_product_id') && !is_int($productData['type_product_id'])) {
                throw new TypeError("O parâmetro type_product_id: {$productData['type_product_id']} precisa ser do tipo Inteiro");
            }

            if (($key == 'name') && !is_string($productData['name'])) {
                throw new TypeError("O parâmetro name: {$productData['name']} precisa ser do tipo string");
            }

            if (($key == 'value') && (!is_float($productData['value']))) {
                throw new TypeError("O parâmetro value: {$productData['value']} precisa ser do tipo float");
            }
        }

        return $this->productRepository->update($id, $productData);
    }
}
