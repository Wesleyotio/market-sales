<?php

namespace App\Domain\Repositories;

use App\Application\Dtos\ProductDto;
use App\Domain\Entities\Product;

interface ProductRepositoryInterface
{
    public function create(ProductDto $product): void;
    public function findCode(int $code): bool;
    public function findById(int $id): ?Product;
    public function findAll(): array;
    public function update(int $id, array $productAttribute): ?int;
    public function delete(int $id): ?int;
}
