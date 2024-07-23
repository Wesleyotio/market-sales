<?php

namespace App\Aplication\UseCases;

use App\Domain\Dtos\ProductDto;
use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepositoryInterface;
use RuntimeException;

class FindProductUseCase {
    
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function action(int $id): Product
    {
        try {
            
            return $this->productRepository->findById($id);
        } catch (\Throwable $th) {
           
            error_log($th->getMessage());
            throw new RuntimeException('FindByIdProductError');
        }
        
    }
}
