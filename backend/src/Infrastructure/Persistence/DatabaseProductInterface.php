<?php

namespace App\Infrastructure\Persistence;

interface DatabaseProductInterface
{
    public function create(string $productData): void;
    public function selectAll(): array;
    public function selectByCode(int $code): bool;
    public function selectById(int $id): ?array;
    public function update(int $id, array $productAttribute): ?int;
    public function delete(int $id): ?int;
   // public function updateAll(int $id, array $productData ): void;
}
