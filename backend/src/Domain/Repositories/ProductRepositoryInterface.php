<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Product;
use App\Domain\Dtos\ProductDto;

interface ProductRepositoryInterface

{
    public function create(ProductDto $product ): void;
    public function findById(int $id): Product;
    public function findAll(): array;
    // public function update(array $array): void;
    // public function delete(int $id): void;

}