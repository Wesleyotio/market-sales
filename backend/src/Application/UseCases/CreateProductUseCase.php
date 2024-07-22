<?php

namespace App\Aplication\UseCases;

use App\Domain\Dtos\ProductDto;
use App\Domain\Repositories\ProductRepositoryInterface;
use Datetime;
use RuntimeException;

class CreateProductUseCase {
    
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function action(int $code, int $typeProductId, string $name, float $value): void
    {
        try {
            //code...
            $product = new ProductDto($code, $typeProductId, $name, $value);
            $this->productRepository->create($product);
        } catch (\Throwable $th) {
            //throw $th;
            error_log($th->getMessage());
            throw new RuntimeException('CreateProductError');
        }
        
    }
}
