<?php

namespace App\Application;

use App\Domain\Dtos\ProductDto;
use App\Domain\Entities\Product;
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

    public function findProductById(int $id): array
    {
        $product =  $this->productRepository->findById($id);
       
        return [
            
            'id'                => $product->getId(),
            'code'              => $product->getCode(),
            'type_product_id'   => $product->getTypeProductId(),
            'name'              => $product->getName(),
            'value'             => $product->getValue(),
            'created_at'        => $product->getCreatedAt(),
            'updated_at'        => $product->getUpdatedAt(),
        ];
    }

    public function findAllProducts(): array 
    {
        return  $this->productRepository->findAll();
    }
    
}