<?php

namespace App\Application\UseCases;

use App\Application\Exceptions\ProductException;
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

        return $this->productRepository->update($id, $productData);
    }
}
