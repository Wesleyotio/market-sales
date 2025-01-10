<?php

namespace App\Application;

use App\Application\UseCases\FindProductUseCase;
use App\Application\UseCases\UpdateProductUseCase;
use App\Application\UseCases\CreateProductUseCase;
use App\Application\Exceptions\ProductException;
use App\Application\UseCases\DeleteProductUseCase;
use App\Application\UseCases\FindAllProductUseCase;
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

        $arrayKeys = ['code', 'type_product_id', 'name', 'value'];
        if (! validateArrayKeys($arrayKeys, $product)) {
            throw new ProductException("Product has missing fields");
        }

        $createProductUseCase = new CreateProductUseCase($this->productRepository);
        $createProductUseCase->action(
            $product['code'],
            $product['type_product_id'],
            $product['name'],
            $product['value']
        );
    }

    public function findProductById(int $id): array
    {
        $findProductUseCase = new FindProductUseCase($this->productRepository);
        $product =  $findProductUseCase->action($id);

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
        $findAllProductUseCase = new FindAllProductUseCase($this->productRepository);
        return $findAllProductUseCase->action();
    }

    public function updateProduct(int $id, array $productData): ?int
    {
        $arrayKeys = ['code', 'type_product_id', 'name', 'value'];

        if (! validateKeysContainedInArray(array_keys($productData), $arrayKeys)) {
            throw new ProductException("unknown fields are being passed for product update");
        }

        $updateProductUseCase = new UpdateProductUseCase($this->productRepository);
        return $updateProductUseCase->action($id, $productData);
    }

    public function updateProductAll(int $id, array $productData): ?int
    {

        $arrayKeys = ['code', 'type_product_id', 'name', 'value'];
        if (! validateArrayKeys($arrayKeys, $productData)) {
            throw new ProductException("product has missing fields for update complete");
        }

        $updateProductUseCase = new UpdateProductUseCase($this->productRepository);
        return $updateProductUseCase->action($id, $productData);
    }

    public function deleteProduct(int $id): ?int
    {
        $deleteProductUseCase = new DeleteProductUseCase($this->productRepository);
        return $deleteProductUseCase->action($id);
    }
}
