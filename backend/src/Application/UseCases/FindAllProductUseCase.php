<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\Application\Dtos\ProductDto;
use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepositoryInterface;
use DateTimeImmutable;

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

        return array_map(function (array $productData) {
            $product = new ProductDto(
                $productData['code'],
                $productData['type_product_id'],
                $productData['name'],
                (float) $productData['value'],
                $productData['id'],
                formatDate($productData['created_at']),
                formatDate($productData['updated_at'])
            );
            return $product->toArray();
        }, $products);
    }
}
