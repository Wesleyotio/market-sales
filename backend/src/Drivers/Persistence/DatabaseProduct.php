<?php

namespace App\Drivers\Persistence;

use App\Infrastructure\Persistence\DatabaseProductInterface;
use PDO;
use RuntimeException;

class DatabaseProduct implements DatabaseProductInterface
{
    use PostgresTrait;
  
    private PDO $pdo;

    public function create(string $productData): void
    {
        $this->pdo = $this->connect();

        try {
            //code...
            validateJson($productData);

            $arrayDecoded = json_decode($productData, true, 512, JSON_THROW_ON_ERROR);

            $createdAt = date('Y-m-d H:i:s'); 
            $updatedAt = date('Y-m-d H:i:s'); 

            $sql = "INSERT INTO products (
                code, 
                type_product_id,
                name,
                value,
                created_at,
                updated_at
            ) 
            VALUES (:code, :type_product_id, :name, :value, :created_at, :updated_at)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':code', $arrayDecoded['code']);
            $stmt->bindParam(':type_product_id', $arrayDecoded['type_product_id']);
            $stmt->bindParam(':name', $arrayDecoded['name']);
            $stmt->bindParam(':value', $arrayDecoded['value']);
            $stmt->bindParam(':created_at', $createdAt);
            $stmt->bindParam(':updated_at', $updatedAt);
            $stmt->execute();

        } catch(\PDOException $e) {
            throw new RuntimeException($e->getMessage());

        }
        
    }

    public function selectById(int $product_id): array
    {
        $this->pdo = $this->connect();

        try {
            
            $sql = "SELECT id, code, type_product_id, name, value, created_at, updated_at
                        FROM products 
                        WHERE id = :id AND deleted_at IS NULL";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            validatePDO($product);

            return $product;
        } catch(\PDOException $e) {
            throw new RuntimeException($e->getMessage());

        }
    }

    public function selectAll(): array
    {
        $this->pdo = $this->connect();

        try {
            
            $sql = "SELECT id, code, type_product_id, name, value, created_at, updated_at
                        FROM products 
                        WHERE deleted_at IS NULL";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_DEFAULT);

            validatePDO($products);
            
            return $products;
        } catch(\PDOException $e) {
            throw new RuntimeException($e->getMessage());

        }
    }
}