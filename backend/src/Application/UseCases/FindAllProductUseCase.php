<?php

namespace App\Aplication\UseCases;

use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepositoryInterface;
use Datetime;
use RuntimeException;

class FindAllProductUseCase {
    
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function action(): array
    {
        try {
            
            $products = $this->productRepository->findAll();

            $arrayProducts = [];

            foreach($products as $product) {

                $object = [
                    'id'                => $product->getId(),
                    'code'              => $product->getCode(),
                    'type_product_id'   => $product->getTypeProductId(),
                    'name'              => $product->getName(),
                    'value'             => $product->getValue(),
                    'created_at'        => $product->getCreatedAt(),
                    'updated_at'        => $product->getUpdatedAt()      
                ];
                array_merge($arrayProducts, $object);
            }

        return $arrayProducts;

            return $this->productRepository->findAll();
        } catch (\Throwable $th) {
            
            error_log($th->getMessage());
            throw new RuntimeException('FindAllProductError');
        }
        
    }
}
