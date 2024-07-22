<?php

namespace App\Drivers\Persistence;

use App\Infrastructure\Persistence\DatabaseProductInterface;
use JsonException;
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
            $this->validateJson($productData);

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

    private function validateJson(string $productData): void 
    {
        if (!json_validate($productData)) {
            throw new JsonException('Json for Product is invalid');
        }
    }
}