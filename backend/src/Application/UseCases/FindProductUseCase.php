<?php

namespace App\Application\UseCases;


use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepositoryInterface;


class FindProductUseCase
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function action(int $id): Product
    {
        $product = $this->productRepository->findById($id);
        return $product;
    }
}
