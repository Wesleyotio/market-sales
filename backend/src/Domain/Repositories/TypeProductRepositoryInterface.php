<?php

namespace App\Domain\Repositories;

use App\Application\Dtos\TypeProductDto;

interface TypeProductRepositoryInterface
{
	public function create(TypeProductDto $typeProduct): void;
	public function findByTypeProductName(string $typeProductName): bool;
	public function findAll(): array;
	// public function update(): void;
	public function delete(int $id): ?int;
}
