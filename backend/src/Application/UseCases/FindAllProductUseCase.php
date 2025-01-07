<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepositoryInterface;
use Datetime;
use RuntimeException;

class FindAllProductUseCase
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function action(): array
    {

        $products = $this->productRepository->findAll();

        $arrayProducts = [];
        if (!empty($products)) {
            foreach ($products as $productData) {
                $object = [
                    'id'                => $productData['id'],
                    'code'              => $productData['code'],
                    'type_product_id'   => $productData['type_product_id'],
                    'name'              => $productData['name'],
                    'value'             => $productData['value'],
                    'created_at'        => formatDate($productData['created_at']),
                    'updated_at'        => formatDate($productData['updated_at'])
                ];
                array_push($arrayProducts, $object);
            }
        }

        return $arrayProducts;
    }
}
