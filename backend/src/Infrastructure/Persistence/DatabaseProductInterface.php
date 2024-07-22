<?php

namespace App\Infrastructure\Persistence;


interface DatabaseProductInterface 
{
   public function create(string $productData ): void;
   // public function selectAll(): array;
   // public function selectById(int $id): object;
   // public function update(array $array ): void;
   // public function delete(int $id): void;
}