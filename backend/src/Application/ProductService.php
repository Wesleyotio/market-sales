<?php

namespace App\Application;

use App\Domain\Dtos\ProductDto;
use App\Domain\Repositories\ProductRepositoryInterface;

class ProductService 
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct(array $product): void
    {
        $product = new ProductDto(
                    $product['code'],
                    $product['type_product_id'],
                    $product['name'],
                    $product['value'],
                );

        $this->productRepository->create($product);
    }

    
}