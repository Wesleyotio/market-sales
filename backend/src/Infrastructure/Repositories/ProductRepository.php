<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Dtos\ProductDto;
use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Infrastructure\Persistence\DatabaseProductInterface;
use RuntimeException;

class ProductRepository implements ProductRepositoryInterface 
{
    private DatabaseProductInterface $databaseProductInterface;

    public function __construct(DatabaseProductInterface $databaseProductInterface)
    {
        $this->databaseProductInterface = $databaseProductInterface;
    }
    
    public function create(ProductDto $product): void
    {

        $arrayProduct = [
            'code' => $product->getCode(),
            'type_product_id' => $product->getTypeProductId(),
            'name' => $product->getName(),
            'value' => $product->getValue(),
        ];

        try {
           
            $jsonProduct = json_encode($arrayProduct, JSON_THROW_ON_ERROR);

        } catch (\JsonException $th) {
            throw new RuntimeException('ProductDataInvalid');
        }
        
        $this->databaseProductInterface->create($jsonProduct);
        
    }

    public function findById(int $id): Product
    {
        try {
          
            $productData = $this->databaseProductInterface->selectById($id);
         
        } catch (\Throwable $th) {
            throw new RuntimeException( $th->getMessage() );
        }


        return new Product(
                $productData['id'],
                $productData['code'],
                $productData['type_product_id'],
                $productData['name'],
                $productData['value'],
                formatDate($productData['created_at']),
                formatDate($productData['updated_at'])
        );
    }

    // public function findAll(): array
    // {
    //     return $this->databaseInterface->selectAll();
    // }

    // public function update(array $array): void
    // {
    //     $this->databaseInterface->update($array);   
    // }

    // public function delete(int $id): void
    // {
    //     $this->databaseInterface->delete($id);
    // }


}
